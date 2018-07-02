$(function(){
    var _serviceVal = 'service', _serviceLocal = 'services';
    var _enterpriseVal = 'enterprise', _enterpriseLocal = 'company';

    
   // Check exist local storage enterprise and service
    if (!checkLocalStorage()) {
        handleLogoutProvider(getTypeLogin());
    }

    // Set value select box from local storage
    if (getTypeLogin() === _serviceVal) {
       setListProviderIntoSelectBox('.'+_serviceVal, _serviceLocal);
    }else if(getTypeLogin() === _enterpriseVal){
       setListProviderIntoSelectBox('.'+_enterpriseVal, _enterpriseLocal);
    }else{
        setListProviderIntoSelectBox('', '');
    }
    
    // Handle change switch login button 
    var $selectProvider = $('#provider_list');
    $selectProvider.on('change', function(){
       try {
           var provider = $(this).val();
           handleLoginProvider(setDataProviderLoginLocalStorage(provider));
       } catch(e) {
           console.log(e);
       }
    });

    // When click on log out all service and enterprise
    var btnLogout = $('.btn-logout-provider');
    btnLogout.on('click', function(){
        handleLogoutProvider(getTypeLogin());
        if (getTypeLogin() === _enterpriseVal) {
            window.localStorage.removeItem(_enterpriseLocal);
        }

        if (getTypeLogin() === _serviceVal) {
            window.localStorage.removeItem(_serviceLocal);
        }
        
    });
    
    // When click on log out service by user enterprise
    var btnLogoutService = $('.btn-logout-service');
    if (btnLogoutService != "undefined"){
        btnLogoutService.on('click', function(){
            var dataObj = {
                _token : App.getToken(),
                listEnterprise: getListProviderFromLocalStorage(_enterpriseLocal),
                currentEnterprise: getCurrentProvider()
            };
            handleLogoutServiceByEnterprise(dataObj);
            return false;

        });
        
    }
    
    /******************************************************************************************
     * =======================================================================================*
     * ** ** ** ** ** ** ** * - F - U - N - C - T - I - O - N - S - ** ** ** ** ** ** ** ** ***
     * =======================================================================================*
     * =======================================================================================*
     *                                  *********************
     *                                  Functions handle page
     *                                  +++++++++++++++++++++
     *                                  =====================
     * =======================================================================================*
     * =======================================================================================*
     */

    /**
     * Validate local item services and enterprises
     * @param  {[type]} provider     [description]
     */
    function checkLocalStorage() {
       
        if (typeof Storage == "undefined") return false;
        if (getTypeLogin() === _enterpriseVal) {
            if (!window.localStorage 
                    || window.localStorage.getItem(_enterpriseLocal) == "undefined" 
                    || window.localStorage.getItem(_enterpriseLocal) == null)  
                return false;
            return true;
        }else if(getTypeLogin() === _serviceVal){
            if (!window.localStorage 
                    || window.localStorage.getItem(_serviceLocal) == "undefined" 
                    || window.localStorage.getItem(_serviceLocal) == null) 
                return false;
            return true;
        }
        
        return true;
    }
    
    /**
     * get ID current provider
     * return string ID <enterprise_cd, service_cd>
     */
    function getCurrentProvider() {
        if ($('input[name="_current"]') == "undefined" || $('input[name="_current"]').length == 0) {
            return '';}
        return $('input[name="_current"]:first').val();
    }
    
    /**
     * Set list for select box for provider
     * =========================================================================
     * @param DOMElement selectElement <Class or ID of element>
     * @param localStorage providerLocal <ID local storage need get list>
     */
    function setListProviderIntoSelectBox(selectElement, providerLocal) {
        // select dom element service or enterprise
        var $selectClass = (selectElement!='')?$(selectElement):'';
        // get current provider login
        var currentProvider = getCurrentProvider();
        var htmlOption = '';
        if (typeof $selectClass == "undefined" || $selectClass.length == 0) { return htmlOption;}

        if (!checkLocalStorage()) { return htmlOption;}
       
        var localItems = getListProviderFromLocalStorage(providerLocal);
        
        if (typeof localItems != "undefined" ) {
            var selectedOpt = '';
            for (var item in localItems) {
                if (providerLocal === _serviceLocal) {
                    selectedOpt = (currentProvider==localItems[item].service_cd)?"selected ='selected'":"";
                    htmlOption += "<option value='"+item+"' "+selectedOpt+">"+localItems[item].service_name+"</option>";
                }else if(providerLocal === _enterpriseLocal){
                    selectedOpt = (currentProvider==localItems[item].enterprise_cd)?"selected ='selected'":"";
                    htmlOption += "<option value='"+item+"' "+selectedOpt+">"+localItems[item].enterprise_name+"</option>";
                }
            }
        }
        
        // Render html view
        $selectClass.html(htmlOption);
    }


    /**
     * Get list provider from select box
     * =========================================================================
     * @param  domElement
     * @return array <List provider>
     */
    function getListProviderFromSelectBox(selectElement) {
        var $selectClass = (selectElement!='')?$(selectElement):"undefined";
        var arrListProvider = [];
        if (typeof $selectClass == "undefined" || $selectClass.length == 0 ) {
            return arrListProvider;
        }

        $selectClass.find('option').each(function(){
            arrListProvider.push($(this).val());
        });

        return arrListProvider;
    }

    /**
     * Get list and sort list provider base on date time login
     * - Get list item from localstorage
     * - Convert to array to sort
     * - Sort by key funtion
     * - Convert array to object again after sort
     * =========================================================================
     * @param itemProvider <provider on local storage>
     * 
     * @return array <List provider object>
     */
    function getListProviderFromLocalStorage(itemProvider) {
        // Initial a variable object and array
        var providerObj = {};
        var providerArr = [];
        
        // If nnot found param, return empty object
        if(typeof itemProvider == "undefined") return providerObj;
        
        // Get string and parse to object from local storage
        var items = JSON.parse(window.localStorage.getItem(itemProvider));

        // Convert object to array with each element is object
        providerArr = Object.keys(items).map(function(k) { return [items[k]] });

        // Handle soft list to desc
        providerArr = sortByDate(providerArr, false);
        
        // Convert array to object
        providerArr.forEach( function(element, index) {
            if (itemProvider === _serviceLocal) {
                providerObj[element[0].service_cd] =  {
                    account             :element[0].account, 
                    service_cd          :element[0].service_cd, 
                    service_name        :element[0].service_name, 
                    last_login_date     :element[0].last_login_date, 
                    login_type          :element[0].login_type, 
                    secret              :element[0].secret
                };
            }else if(itemProvider == _enterpriseLocal){
                providerObj[element[0].enterprise_cd] = {
                    account             :element[0].account, 
                    enterprise_cd       :element[0].enterprise_cd, 
                    enterprise_name     :element[0].enterprise_name, 
                    last_login_date     :element[0].last_login_date, 
                    login_type          :element[0].login_type, 
                    secret              :element[0].secret
                };
            }
        });
       
       return providerObj;
    }


    /**
     * Get current type login of provider
     * =========================================================================
     * @return string <service|enterprise|''>
     */
    function getTypeLogin() {
        var $selectProvider = $('#provider_list');
        if (typeof $selectProvider == "undefined") { return '';}

        // Check current selectbox is an enterprise or service
        if ($selectProvider.hasClass(_serviceVal)) {
            return _serviceVal;
        }else if($selectProvider.hasClass(_enterpriseVal)){
            return _enterpriseVal;
        }else{
            return '';
        }
    }


    /**
     * Get data of provider via Local Storage
     * =========================================================================
     * @param string providerID <enterprise / service>
     * @return object
     */
    function setDataProviderLoginLocalStorage(providerID) {
        var dataObject = {};
        var provider = getTypeLogin();
        var dataProviderArr = [];

        switch (provider) {
            case _enterpriseVal:
                if (getListProviderFromLocalStorage(_enterpriseLocal).hasOwnProperty(providerID)) {
                    dataProviderArr = getListProviderFromLocalStorage(_enterpriseLocal)[providerID];
                    dataObject['login_type']    = 0;
                    dataObject['type_cd']       = dataProviderArr['enterprise_cd'];
                    dataObject['login_id']      = dataProviderArr['account'];
                    dataObject['password']      = dataProviderArr['secret'];
                }
                break;
             case _serviceVal:
                if (getListProviderFromLocalStorage(_serviceLocal).hasOwnProperty(providerID)) {
                    dataProviderArr = getListProviderFromLocalStorage(_serviceLocal)[providerID];
                    dataObject['login_type']    = 1;
                    dataObject['type_cd']       = dataProviderArr['service_cd'];
                    dataObject['login_id']      = dataProviderArr['account'];
                    dataObject['password']      = dataProviderArr['secret'];
                }
                break;
            default:
                break;
        }

        dataObject['_token'] = App.getToken();

        return dataObject;
    }


    /**
     * Handle login with data login
     * =========================================================================
     * @param  object data <param to handle login>
     * @param  String redirect <redirect after login>
     * @return void
     */
    function handleLoginProvider(dataObj, btnLogin, redirect) {
        $.ajax({
            type : 'POST',
            url: "/page/switch-login",
            data: dataObj,
            beforeSend: function(){
               if (typeof btnLogin != "undefined" && btnLogin != '') {
                   if ( btnLogin.hasClass('lbl-loading')){
                        btnLogin.removeClass('lbl-loading').removeProp('disabled');
                    }else{
                        btnLogin.addClass('lbl-loading').prop("disabled", "disabled");
                    }
               }
            },
            success: function(data){
                if (data!==null && data.status == "success") {
                    updateLocalStorageTime(data.type_cd, data.last_login_date);
                    if (typeof redirect == "undefined" || redirect == '' || redirect == null) {
                        window.location.reload();
                    }else {
                        window.location.href = redirect;
                    }
                } else {
                    alert('ログインに失敗しました。'); // Login failed
                    window.location.reload();
                    return false;
                }

            },
            error: function(error){
                alert('ログインに失敗しました。'); // Login failed
                window.location.reload();
                return false;
            },

            timeout: 10000
        });
        
    }
    

    /**
     * Update localStorage "last_login_date" property
     * - Update provider base id provider
     * - Value pass to set update
     * =========================================================================
     * @param  string id  <ID provider need to update, eg: nttls01, nttls02,etc...>
     * @param  string value <Value update>
     * 
     * @return boolean [description]
     */
    function updateLocalStorageTime(id, value) {
        // Get current provider base on selectbox class
        var provider = '';
        if (getTypeLogin() === _enterpriseVal) {
            provider = _enterpriseLocal;
        }else if(getTypeLogin() === _serviceVal){
            provider = _serviceLocal;
        }

        // Get list provider from local storage
        var listProvider = getListProviderFromLocalStorage(provider);

        // Loop list provider and check if provider is need to update
        for (var item in listProvider) {
            if (item == id) {
                listProvider[item].last_login_date = value;
            }
        }

        // Set item again after update
        if (window.localStorage.setItem(provider, JSON.stringify(listProvider))) {
            return true;
        }

        return false;
    }


    /**
     * Handle logout all provider when user click logout
     * - Add redirect after logout with each provider
     * - handle ajax logout
     * =========================================================================
     * @param  String provider <provider get from selectbox>
     * @param  String redirect <redirect after logout>
     * 
     * @return void <redirect or error>
     */
    function handleLogoutProvider(provider) {
        // Redirect to login screen with each provider
        var urlLogout = '', urlRedirect = '';
        if (provider === _enterpriseVal) {
           urlLogout = '/company/logout';
           urlRedirect = '/company/login';
        }else if(provider === _serviceVal){
            urlLogout = '/service/logout';
            urlRedirect = '/service/login'
        }else{
            urlLogout = '';
            urlRedirect = '';
        }

        // Handle ajax send data to server
        $.ajax({
            type : 'POST',
            url: urlLogout,
            data: {"provider": provider, "_token":App.getToken()},
            success: function(data){
                // If user defined path to redirect
                if(urlRedirect != ''){
                   window.location.href = urlRedirect; 
                }else{
                   window.location.reload();
                }
            },
            // Not do anything when error
            error: function(error){
                window.location.reload();
                return false;
            }
        });
    }


    /**
     * Handle logout service when user company login
     * - Add redirect after logout with each provider
     * - handle ajax logout
     * =========================================================================
     * @param  Json dataForm <data sent to server>
     * @param  String redirect <redirect after logout>
     * 
     * @return void <redirect or error>
     */
    function handleLogoutServiceByEnterprise(dataForm, redirect) {
       $.ajax({
           type: 'POST',
           url: '/page/logout-service',
           data: dataForm,
           success: function(data){
               // Error happen, alert a error message
                if (typeof data.error != "undefined" && data.error) {
                    return false;
                }
                
                // Redirect when define a path particility
                if(typeof redirect != "undefined" && redirect != null && redirect != ''){
                   window.location.href = redirect; 
                   return true;
                }

                // Reload page when logout
                window.location.reload();
           },
           error: function(errors){
               window.location.reload();
               return false;
           }
       });
    }
    

    /**
     * Sort list provider login base "last_login_date" 
     * - Default is DESC 
     * - if desc is false, sort ASC
     * =========================================================================
     * @param  array listProvider <List data to sort>
     * @param  boolean desc <Default sort to desc>
     * @return void
     */
    function sortByDate(listProvider, desc) {
        if (typeof desc != "undefined") {
            if (!desc) {
                // IE not working parse Date format separate with -
                listProvider.sort(function(a,b){
                    return (new Date(b[0].last_login_date.replace('-', '/')) - new Date(a[0].last_login_date.replace('-', '/')));
                });
            }else{
                listProvider.sort(function(a,b){
                    return (new Date(a[0].last_login_date.replace('-', '/')) - new Date(b[0].last_login_date.replace('-', '/')));
                });
            }
        }
        
        return listProvider;
    }
    
});