<?php

/**
 * File company business
 *
 * Handle business related to company
 * @package App\Business
 * @author Rikkei.Trihnm
 * @date 2018/06/19
 */

namespace App\Business;

use App\Repositories\Company\CompanyInterface;
use App\Repositories\Ship\ShipInterface;
use App\Repositories\Contract\ContractInterface;
use App\Common\Constant;

class CompanyBusiness
{
    protected $companyRepository;
    protected $contractRepository;
    protected $shipRepository;

    public function __construct(CompanyInterface $companyInterface)
    {
        $this->companyRepository = $companyInterface;
    }

    /**
     * Business init page company
     * @access public
     * @param string column
     * @param int orderBy asc = 0 or null / desc = 1
     * @return Paginate
     */
    public function initListCompany($column = null, $orderBy = null)
    {
        $query = $this->companyRepository->getListCompanyCommon()
            ->groupBy([
                'm_company.id',
                'm_service.id',
            ]);

        // Check order by is desc or asc
        $orderBy = $orderBy ? 'desc' : 'asc';

        return $query->orderBy($this->_transFormNameToColumn($column), $orderBy)
            ->orderBy('m_company.id', $orderBy)
            ->paginate(config('pagination.default'));
    }

    /**
     * Business search company
     * @access public
     * @param int groupType company = 0/ service = 1
     * @param int pagination
     * @param string column
     * @param int orderBy asc = 0 or null / desc = 1
     * @return Paginate
     */
    public function searchCompany(
        $groupType = 0,
        $pagination = 10,
        $column = null,
        $orderBy = null,
        $showType = Constant::SHOW_ACTIVE
    ) {
        // Check group type is exists if not set default group company
        if ($groupType != config('company.group_company') && $groupType != config('company.group_service')) {
            $groupType = config('company.group_company');
        }

        // Check load result is exists if not set default is 10
        if (!in_array($pagination, config('pagination.paginate_value'))) {
            $pagination = config('pagination.default');
        }

        // Check order by is desc or asc
        $orderBy = $orderBy ? 'desc' : 'asc';

        // Return limit companies
        return $this->companyRepository->getListCompanyCommon($groupType, $showType)
            ->groupBy([
                !$groupType ? 'm_company.id' : 'm_service.id',
                !$groupType ? 'm_service.id' : 'm_company.id',
            ])
            ->orderBy($this->_transFormNameToColumn($column, $groupType), $orderBy)
            ->orderBy(!$groupType ? 'm_company.id' : 'm_service.id', $orderBy)
            ->paginate($pagination);
    }

    /**
     * Business filter company
     * @access public
     * @param array param condition filter
     * @param int groupType company = 0/ service = 1
     * @param int pagination
     * @param array option sort with column and order by
     * @return Paginate
     */
    public function filterCompany($param, $groupType = 0, $pagination = 10, $option = [])
    {
        if ($groupType != config('company.group_company') && $groupType != config('company.group_service')) {
            $groupType = config('company.group_company');
        }

        if (!in_array($pagination, config('pagination.paginate_value'))) {
            $pagination = config('pagination.default');
        }

        $param = $this->_checkValueExists($param);
        $option['sortBy'] = $option['sortBy'] ? 'desc' : 'asc';

        return $this->companyRepository->getListCompanyCommon($groupType, $option['showType'])
            ->conditionSearchCompany($param)
            ->groupBy([
                !$groupType ? 'm_company.id' : 'm_service.id',
                !$groupType ? 'm_service.id' : 'm_company.id',
            ])
            ->orderBy($this->_transFormNameToColumn($option['field'], $groupType), $option['sortBy'])
            ->orderBy(!$groupType ? 'm_company.id' : 'm_service.id', $option['sortBy'])
            ->paginate($pagination);
    }

    /**
     * Check parameter is match with database
     * @access private
     * @param array params
     * @return array params
     */
    private function _checkValueExists($params)
    {
        $data = [];

        $data['filter-company'] = !empty($params['filter-company']) ?  $params['filter-company'] : '';
        $data['filter-service'] = !empty($params['filter-service']) ?  $params['filter-service'] : '';
        $data['filter-nation'] = !empty($params['filter-nation']) ? $params['filter-nation'] : '';
        $data['filter-address'] = !empty($params['filter-address']) ? $params['filter-address'] : '';
        $data['filter-company-operation'] = !empty($params['filter-company-operation']) ? $params['filter-company-operation'] : '';
        $data['filter-company-ope-person-name-1'] = !empty($params['filter-company-ope-person-name-1'])
            ? $params['filter-company-ope-person-name-1']
            : '';
        $data['filter-company-ope-person-email-1'] = !empty($params['filter-company-ope-person-email-1'])
            ? $params['filter-company-ope-person-email-1']
            : '';
        $data['filter-company-ope-person-phone-1'] = !empty($params['filter-company-ope-person-phone-1'])
            ? $params['filter-company-ope-person-phone-1']
            : '';
        $data['filter-company-ope-person-name-2'] = !empty($params['filter-company-ope-person-name-2'])
            ? $params['filter-company-ope-person-name-2']
            : '';
        $data['filter-company-ope-person-email-2'] = !empty($params['filter-company-ope-person-email-2'])
            ? $params['filter-company-ope-person-email-2']
            : '';
        $data['filter-company-ope-person-phone-2'] = !empty($params['filter-company-ope-person-phone-2'])
            ? $params['filter-company-ope-person-phone-2']
            : '';

        return $data;
    }

    /**
     * Return array map with column in database
     * @access private
     * @param string name
     * @param int option
     * @description default with option = 0 will be return m_company.name_jp
     * @return String column name
     */
    private function _transFormNameToColumn($name, $option = 0)
    {
        $columns = [
            'filter-company' => 'm_company.name_jp',
            'filter-service' => 'm_service.name_jp',
            'filter-address' => 'm_company.head_office_address',
            'filter-nation' => 'm_nation.name_jp',
            'filter-company-operation' => 'm_company_operation.name',
        ];

        return !empty($columns[$name]) ? $columns[$name] : ($option ? $columns['filter-service'] : $columns['filter-company']);
    }

    /**
     * Get detail group company/ detail group service
     * @access public
     * @param int id
     * @param int type group company = 0/ type group service = 1
     * @throws Exception
     * @return Collection
     */
    public function getDetailGroup($id, $type = 0)
    {
        if (!$id) throw new \Exception("Error");

        return $this->companyRepository->getDetailByGroup($id, $type);
    }

    /**
     * Function get detail company by id
     * @param int id
     * @param array columns
     * @return array
     */
    public function getDetailCompany($id, $columns = ['*'])
    {
        $company = $this->companyRepository->getDetailCompanyWithRelation($id, [
            'm_company.*',
            'm_nation.name_jp as nation_name_jp',
            'm_nation.name_en as nation_name_en',
            'm_company_operation.name as ope_company_name',
            'm_billing_method.name_jp as billing_name_jp',
            'm_billing_method.name_en as billing_name_en',
            'm_billing_method.id as billing_id',
            'm_currency.code as currency_code_company',
        ]);

        return [
            'company' => $company,

            // Cast to model MNation
            'nation' => new \App\Models\MNation([
                'name_jp' => $company->nation_name_jp,
                'name_en' => $company->nation_name_en
            ]),

            // Cast to model MCompanyOperation
            'companyOperation' => new \App\Models\MCompanyOperation([
                'name' => $company->ope_company_name,
            ]),

            // Cast to model MBillingMethod
            'billingMethod' => new \App\Models\MBillingMethod([
                'name_jp' => $company->billing_name_jp,
                'name_en' => $company->billing_name_en,
                'id' => $company->billing_id,
            ]),

            // Cast to model MCurrency
            'currency' => new \App\Models\MCurrency([
                'code' => $company->currency_code_company,
            ]),
        ];
    }

    /**
     * Function get currency of company
     * @param int companyId
     * @return int
     */
    public function getCompanyCurrencyId($companyId)
    {
        // Find or fail company get currency id
        $company = $this->companyRepository->getCompanyCurrencyId($companyId);

        return $company['currency_id'];
    }

    /**
     * Function update currency  company
     * @param int companyId
     * @param int currencyId
     * @return bool|mixed
     */
    public function updateBillingMethod($companyId, $billingMethodId)
    {
        // Update billing method when del_flag = 0
        return $this->companyRepository->updateCompanyBillingMethod($companyId, $billingMethodId);
    }

    /**
     * Function delete company
     * @param int companyId
     * @return boolean
     */
    public function deleteCompany($companyId)
    {
        // Get intantce ship repository from container
        $this->shipRepository = app(ShipInterface::class);

        // Get ship ids
        $ships = $this->shipRepository->getShipByCompanyId($companyId, ['id']);

        // Setting update time
        $updatedAt = \Carbon\Carbon::now()->format('Y-m-d H:i:s');

        // Update ship del_flag = 1
        $this->shipRepository->updateDeleteShip(array_column($ships, 'id'), [
            'del_flag' => Constant::DELETE_FLAG_TRUE,
            'updated_at' => $updatedAt,
            'updated_by' => auth()->id(),
        ]);

        // Get intantce contract repository from container
        $this->contractRepository = app(ContractInterface::class);

        // Delete new contract watting approved or new contract have been reject
        $this->contractRepository->deleteContract(array_column($ships, 'id'), 'ship_id');

        // Update contract active or pending with approved_flag = 0 or 3 when delete company
        $this->contractRepository->updateDeleteContract(array_column($ships, 'id'), [
                'deleted_at' => \Carbon\Carbon::now()->format('Y-m-d'),
                'approved_flag' => Constant::STATUS_APPROVED,
                'reason_reject' => null,
                'updated_at' => $updatedAt,
                'updated_by' => auth()->id(),
                'del_flag' => Constant::DELETE_FLAG_TRUE,
            ], 'ship_id');

        return $this->companyRepository->update($companyId, [
            'del_flag' => Constant::DELETE_FLAG_TRUE,
            'updated_at' => $updatedAt,
            'updated_by' => auth()->id(),
        ]);
    }

    /**
     * Function check exists company id
     *
     * @param int $companyId
     * @return boolean
     */
    public function checkExistsCompanyId($companyId)
    {
        return $this->companyRepository->checkCompanyExists($companyId);
    }

    /**
     * Function init data for create company
     *
     * @return array
     */
    public function initCreateCompany()
    {
        $nationRepository = app(\App\Repositories\Nation\NationInterface::class);
        $nations = $nationRepository->getAllNation(['id', 'name_jp', 'name_en']);

        $currencyRepository = app(\App\Repositories\MCurrency\MCurrencyInterface::class);
        $currency = $currencyRepository->getAllCurrency(['id', 'code']);

        $currencyId = $currency->first()->id;
        $billingMethodRepository = app(\App\Repositories\BillingMethod\BillingMethodInterface::class);

        // Check if validation fail then get old value of currency id
        $currencyId = old('company-currency-id') ?: $currencyId;
        $billingMethod = $billingMethodRepository->getBillingMethodByCurrency($currencyId, ['id', 'name_jp', 'name_en']);

        $companyOpeRepository = app(\App\Repositories\CompanyOperation\CompanyOpeInterface::class);
        $companyOpe = $companyOpeRepository->getCompanyOperationByPermisstion(['id', 'name', 'short_name']);

        $shipTypeRepository = app(\App\Repositories\ShipType\ShipTypeInterface::class);
        $shipTypes = $shipTypeRepository->getAllShipType(['id', 'code', 'type']);

        $classificationRepository = app(\App\Repositories\Classification\ClassificationInterface::class);
        $classificationies = $classificationRepository->getAllShipClassification(['id', 'code', 'name_en','name_jp']);

        return [
            'nations' => $nations,
            'currency' => $currency,
            'billingMethod' => $billingMethod,
            'companyOpe' => $companyOpe,
            'shipTypes' => $shipTypes,
            'classificationies' =>  $classificationies,
        ];
    }

    /**
     * Function check name company is duplicate
     *
     * @param string $namejp
     * @param string $nameEn
     * @return array
     */
    public function checkExistsWhenCreate($data)
    {
        $existsJp = $this->companyRepository->existsNameCompany($data['nameJp']);

        $existsEn = $this->companyRepository->existsNameCompany($data['nameEn'], 1);

        $messages = [];

        if ($existsJp) {
            $messages[] = trans('common-message.warning.W004', ['attribute' => trans('company.lbl_title_company_name_jp')]);
        }

        if ($existsEn) {
            $messages[] = trans('common-message.warning.W004', ['attribute' => trans('company.lbl_title_company_name_en')]);
        }

        $shipBussiness = app(\App\Business\ShipBusiness::class);
        $existsShipName = $shipBussiness->checkExistShipName($data['shipName']);
        $existsImo = $shipBussiness->checkExistShipImoNumber($data['imoNumber']);

        if ($existsShipName) {
            $messages[] = trans('common-message.warning.W004', ['attribute' => trans('ship.lbl_title_ship_name')]);
        }

        if ($existsImo) {
            $messages[] = trans('common-message.warning.W004', ['attribute' => trans('ship.lbl_title_imo_number')]);
        }

        return [
            'existsJp' => $existsJp,
            'existsEn' => $existsEn,
            'existsShipName' => $existsShipName,
            'existsImo' => $existsImo,
            'message' => $messages,
        ];
    }

    /**
     * Function store company
     *
     * @param array $dataCompany
     * @param array $dataShip
     * @return boolean
     */
    public function storeCompany($dataCompany, $dataShip)
    {
        // Check and format month billing
        $monthBilling = null;
        if (!empty($dataCompany['slb-company-month-billing']) && is_array($dataCompany['slb-company-month-billing'])) {
            foreach ($dataCompany['slb-company-month-billing'] as $index => $month) {
                // Add 0 to month if month is less than 10
                if ($month < 10 && strlen($month) < 2) {
                    $monthBilling .= '0';
                }

                $monthBilling .= $month;

                // Add , to string when the month is not end
                if ($index < count($dataCompany['slb-company-month-billing']) - 1) {
                    $monthBilling .= ',';
                }
            }
        }

        $companyId = $this->companyRepository->insertGetId([
            'name_jp' => $dataCompany['txt-company-name-jp'],
            'name_en' => $dataCompany['txt-company-name-en'],
            'nation_id' => $dataCompany['company-nation-id'],
            'postal_code' => $dataCompany['txt-company-postal-code'],
            'head_office_address' => $dataCompany['txt-company-address'],
            'represent_person' => $dataCompany['txt-company-represent-person'],
            'fund' => $dataCompany['txt-company-fund'],
            'employees_number' => $dataCompany['txt-company-employee-number'],
            'year_research' => $dataCompany['txt-company-year-research'],
            'billing_method_id' => $dataCompany['slb-company-billing-method'],
            'month_billing' => $monthBilling,
            'payment_deadline_no' => $dataCompany['txt-company-payment-deadline-no'],
            'billing_day_no' => $dataCompany['txt-company-site'],
            'currency_code' => $dataCompany['txt-company-currency-code'],
            'currency_id' => $dataCompany['company-currency-id'],
            'ope_person_name_1' => $dataCompany['txt-ope-name-1'],
            'ope_position_1' => $dataCompany['txt-ope-position-1'],
            'ope_department_1' => $dataCompany['txt-ope-department-1'],
            'ope_postal_code_1' => $dataCompany['txt-ope-postal-code-1'],
            'ope_address_1' => $dataCompany['txt-ope-address-1'],
            'ope_phone_1' => $dataCompany['txt-ope-phone-1'],
            'ope_fax_1' => $dataCompany['txt-ope-fax-1'],
            'ope_email_1' => $dataCompany['txt-ope-email-1'],
            'ope_person_name_2' => $dataCompany['txt-ope-name-2'],
            'ope_position_2' => $dataCompany['txt-ope-position-2'],
            'ope_department_2' => $dataCompany['txt-ope-department-2'],
            'ope_postal_code_2' => $dataCompany['txt-ope-postal-code-2'],
            'ope_address_2' => $dataCompany['txt-ope-address-2'],
            'ope_phone_2' => $dataCompany['txt-ope-phone-2'],
            'ope_fax_2' => $dataCompany['txt-ope-fax-2'],
            'ope_email_2' => $dataCompany['txt-ope-email-2'],
            'ope_company_id' => $dataCompany['slb-company-operation'],
            'url'  => $dataCompany['txt-company-url'],
            'del_flag' => Constant::DELETE_FLAG_FALSE,
            'created_by' => auth()->id(),
            'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        $shipRepository = app(\App\Repositories\Ship\ShipInterface::class);
        $ship = $shipRepository->insertGetId([
            'name' => $dataShip['txt-ship-name'],
            'company_id' => $companyId,
            'imo_number' => $dataShip['txt-ship-imo-number'],
            'nation_id' => $dataShip['ship-nation-id'],
            'classification_id' => $dataShip['slb-ship-classification'],
            'type_id' => $dataShip['slb-ship-type'],
            'del_flag' => Constant::DELETE_FLAG_FALSE,
            'created_by' => auth()->id(),
            'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }

    /**
     * Function get company and information to show edit
     *
     * @param integer $companyId
     * @return array
     */
    public function initEditCompany($companyId)
    {
        $company = $this->companyRepository->findOrFail($companyId);

        $nationRepository = app(\App\Repositories\Nation\NationInterface::class);
        $nations = $nationRepository->getAllNation(['id', 'name_jp', 'name_en']);

        $currencyRepository = app(\App\Repositories\MCurrency\MCurrencyInterface::class);
        $currency = $currencyRepository->getAllCurrency(['id', 'code']);

        $currencyId = $company->currency_id;
        $billingMethodRepository = app(\App\Repositories\BillingMethod\BillingMethodInterface::class);

        // Check if validation fail then get old value of currency id
        $currencyId = old('company-currency-id') ?: $currencyId;
        $billingMethod = $billingMethodRepository->getBillingMethodByCurrency($currencyId, ['id', 'name_jp', 'name_en']);

        $companyOpeRepository = app(\App\Repositories\CompanyOperation\CompanyOpeInterface::class);
        $companyOpe = $companyOpeRepository->getCompanyOperationByPermisstion(['id', 'name', 'short_name']);

        $checkCompanyHasUsingService = $this->companyRepository->checkCompanyHasUsingService($companyId);

        return [
            'company' => $company,
            'nations' => $nations,
            'currency' => $currency,
            'billingMethod' => $billingMethod,
            'companyOpe' => $companyOpe,
            'existsContract' => $checkCompanyHasUsingService,
        ];
    }

    /**
     * Function check exists company when update
     *
     * @param integer $idCompany
     * @param string $nameJp
     * @param string $nameEn
     * @return array
     */
    public function checkExistsWhenUpdate($idCompany, $nameJp, $nameEn)
    {
        $existsJp = $this->companyRepository->checkExistsNameUpdate($idCompany, $nameJp);

        $existsEn = $this->companyRepository->checkExistsNameUpdate($idCompany, $nameEn, true);

        $messages = [];

        if ($existsJp) {
            $messages[] = trans('common-message.warning.W004', ['attribute' => trans('company.lbl_title_company_name_jp')]);
        }

        if ($existsEn) {
            $messages[] = trans('common-message.warning.W004', ['attribute' => trans('company.lbl_title_company_name_en')]);
        }

        return [
            'existsJp' => $existsJp,
            'existsEn' => $existsEn,
            'message' => $messages,
        ];
    }

    /**
     * Function update company infomation
     *
     * @param integer $id
     * @param array $data
     * @return boolean
     */
    public function updateCompanyInfo($id, $dataCompany)
    {
        // Check and format month billing
        $monthBilling = null;
        if (!empty($dataCompany['slb-company-month-billing']) && is_array($dataCompany['slb-company-month-billing'])) {
            foreach ($dataCompany['slb-company-month-billing'] as $index => $month) {
                // Add 0 to month if month is less than 10
                if ($month < 10 && strlen($month) < 2) {
                    $monthBilling .= '0';
                }

                $monthBilling .= $month;

                // Add , to string when the month is not end
                if ($index < count($dataCompany['slb-company-month-billing']) - 1) {
                    $monthBilling .= ',';
                }
            }
        }

        // Get data for update
        $data = [
            'name_jp' => $dataCompany['txt-company-name-jp'],
            'name_en' => $dataCompany['txt-company-name-en'],
            'nation_id' => $dataCompany['company-nation-id'],
            'postal_code' => $dataCompany['txt-company-postal-code'],
            'head_office_address' => $dataCompany['txt-company-address'],
            'represent_person' => $dataCompany['txt-company-represent-person'],
            'fund' => $dataCompany['txt-company-fund'],
            'employees_number' => $dataCompany['txt-company-employee-number'],
            'year_research' => $dataCompany['txt-company-year-research'],
            'billing_method_id' => $dataCompany['slb-company-billing-method'],
            'month_billing' => $monthBilling,
            'payment_deadline_no' => $dataCompany['txt-company-payment-deadline-no'],
            'billing_day_no' => $dataCompany['txt-company-site'],
            'currency_code' => $dataCompany['txt-company-currency-code'],
            'ope_person_name_1' => $dataCompany['txt-ope-name-1'],
            'ope_position_1' => $dataCompany['txt-ope-position-1'],
            'ope_department_1' => $dataCompany['txt-ope-department-1'],
            'ope_postal_code_1' => $dataCompany['txt-ope-postal-code-1'],
            'ope_address_1' => $dataCompany['txt-ope-address-1'],
            'ope_phone_1' => $dataCompany['txt-ope-phone-1'],
            'ope_fax_1' => $dataCompany['txt-ope-fax-1'],
            'ope_email_1' => $dataCompany['txt-ope-email-1'],
            'ope_person_name_2' => $dataCompany['txt-ope-name-2'],
            'ope_position_2' => $dataCompany['txt-ope-position-2'],
            'ope_department_2' => $dataCompany['txt-ope-department-2'],
            'ope_postal_code_2' => $dataCompany['txt-ope-postal-code-2'],
            'ope_address_2' => $dataCompany['txt-ope-address-2'],
            'ope_phone_2' => $dataCompany['txt-ope-phone-2'],
            'ope_fax_2' => $dataCompany['txt-ope-fax-2'],
            'ope_email_2' => $dataCompany['txt-ope-email-2'],
            'ope_company_id' => $dataCompany['slb-company-operation'],
            'url'  => $dataCompany['txt-company-url'],
            'updated_by' => auth()->id(),
            'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
        ];

        // Check have update currency id
        if (!empty($dataCompany['company-currency-id']) && !$this->companyRepository->checkCompanyHasUsingService($id)) {
            $data['currency_id'] = $dataCompany['company-currency-id'];
        }

        $this->companyRepository->update($id, $data);

        return true;
    }

    /**
     * Function get operation company id
     *
     * @param integer $companyId
     * @throws Exception
     * @return integer
     */
    public function getOpeCompany($companyId)
    {
        return $this->companyRepository->findOrFail($companyId, ['ope_company_id'])->ope_company_id;
    }
}
