<?php

/**
 * Ship management Business
 *
 * @package App\Business
 * @author Rikkei.QuyenL
 * @date 2018/07/05
 */

namespace App\Business;

use App\Common\Constant;
use App\Repositories\Ship\ShipInterface;

/**
 * Class ShipBusiness Handle business related ship
 */
class ShipBusiness
{
    /**
     * @var $_shipRepository
     */
    protected $_shipRepository;

    /**
     * ShipBusiness constructor.
     *
     * @access public
     * @param ShipInterface $shipInterface
     * @return void
     */
    public function __construct(ShipInterface $shipInterface)
    {
        $this->_shipRepository = $shipInterface;
    }

    /**
     * Get list ship data
     *
     * @param null|string $filterColumn default null
     * @param int $perPage
     * @param null|int $orderBy ASC: 0, null | DESC: 1
     * @param null|int $companyId
     * @return object
     */
    public function getListShip($filterColumn = null,
                                $perPage = Constant::PAGINATION_PER_PAGE ,
                                $orderBy = null,
                                $companyId = null)
    {
        // Call shipRepository and Create list ship query
        $query = $this->_shipRepository
            ->getCommonListShipQuery($companyId)
            ->groupBy([
                'm_ship.id',
                'm_service.id',
            ]);

        // Check total record per page, if it not have set default it
        if (!in_array($perPage, Constant::ARY_PAGINATION_PER_PAGE)) {
            $perPage = Constant::PAGINATION_PER_PAGE;
        }

        // Check order by is descending or ascending
        $sortType = $orderBy ? 'DESC' : 'ASC';

        return $query->orderBy($this->_convertToColumn($filterColumn), $sortType)
            ->orderBy('m_ship.id', $sortType)
            ->paginate($perPage);
    }

    /**
     * Business filter company
     *
     * @param array $filterData conditions filter
     * @param int $pagination total record per page
     * @param array $option sort with column and order by
     * @param null|int $companyId
     * @return mixed
     */
    public function filterCompany($filterData,
                                  $pagination = Constant::PAGINATION_PER_PAGE,
                                  $option = [],
                                  $companyId = null)
    {
        // Check pagination
        if (!in_array($pagination, Constant::ARY_PAGINATION_PER_PAGE)) {
            $pagination = Constant::PAGINATION_PER_PAGE;
        }

        // Get filter search data
        $filters = $this->_getFilterData($filterData);

        // Check order by is descending or ascending
        $option['orderBy'] = $option['orderBy'] ? 'DESC' : 'ASC';

        return $this->_shipRepository
            ->getCommonListShipQuery($companyId)
            ->conditionSearchShip($filters)
            ->groupBy(['m_ship.id', 'm_service.id',])
            ->orderBy($this->_convertToColumn($option['field']), $option['orderBy'])
            ->orderBy('m_ship.id', $option['orderBy'])
            ->paginate($pagination);
    }

    /**
     * Return array map with column in database
     *
     * @access private
     * @param string $name
     * @return string
     */
    private function _convertToColumn($name = null)
    {
        $columns = [
            'filter-ship-name' => 'm_ship.name',
            'filter-company' => 'm_company.name_jp',
            'filter-classification' => 'm_ship_classification.name_jp',
            'filter-ship-type' => 'm_ship_type.type',
            'filter-imo-number' => 'm_ship.imo_number',
            'filter-ship-nation' => 'm_nation.name_jp',
        ];

        return !empty($name) ? $columns[$name] : 'm_ship.name';
    }

    /**
     * Filter request send data
     *
     * @access private
     * @param array $params filter request data
     * @return array
     */
    private function _getFilterData($params)
    {
        // Init empty array value
        $data = [];

        // Filter if have request value, empty in other case
        $data['filter-ship-name'] = !empty($params['filter-ship-name']) ?  $params['filter-ship-name'] : '';
        $data['filter-company'] = !empty($params['filter-company']) ?  $params['filter-company'] : '';
        $data['filter-classification'] = !empty($params['filter-classification']) ?  $params['filter-classification'] : '';
        $data['filter-ship-type'] = !empty($params['filter-ship-type']) ? $params['filter-ship-type'] : '';
        $data['filter-imo-number'] = !empty($params['filter-imo-number']) ? $params['filter-imo-number'] : '';
        $data['filter-ship-nation'] = !empty($params['filter-ship-nation']) ? $params['filter-ship-nation'] : '';
        $data['filter-service-name'] = !empty($params['filter-service-name']) ? $params['filter-service-name'] : '';

        return $data;
    }

    /**
     * Business init search ship
     *
     * @access public
     * @param int $companyId
     * @return mixed query
     */
    public function initSearchShip($companyId)
    {
        $dataQuery = $this->_shipRepository->getListShip($companyId);

        return $dataQuery;
    }

    /**
     * Business init search ship
     *
     * @param int $companyId
     * @param int $idShipSearch
     * @param string $nameShipSearch
     * @return mixed
     */
    public function searchShip($companyId, $idShipSearch, $nameShipSearch)
    {
        $dataQuery = $this->_shipRepository->searchListShip($companyId,$idShipSearch,$nameShipSearch);

        return $dataQuery;
    }

    /**
     * Get list view data
     * 1. Get list company
     * 2. Get list nation
     * 3. Get list classification
     * 4. Get list ship type
     *
     * @param int $companyId request company id
     * @return array
     */
    public function getViewData($companyId = null)
    {
        // Call repository and get list view data
        $listCompany = $this->_shipRepository->getListCompany();
        $listNation = $this->_shipRepository->getListNation();
        $listClassification = $this->_shipRepository->getListClassification();
        $listShipType = $this->_shipRepository->getListShipType();

        return [
            'selectedCompanyId' => !empty($companyId) ? $companyId : null,
            'company' => array_pluck($listCompany, 'name_jp', 'id'),
            'nation' => $listNation,
            'classification' => array_pluck($listClassification, 'name_jp', 'id'),
            'shipType' => array_pluck($listShipType, 'type', 'id')
        ];
    }

    /**
     * Call repository and insert ship data
     *
     * @access public
     * @param array $validatedData
     * @return bool
     */
    public function createShip($validatedData)
    {
        // Convert insert data
        $insertData = $this->_convertInsertData($validatedData);

        return $this->_shipRepository->createShip($insertData);
    }

    /**
     * Call repository and update ship data
     *
     * @access public
     * @param int $shipId
     * @param array $validatedData
     * @return bool
     */
    public function updateShip($shipId, $validatedData)
    {
        // Convert update data
        $updateData = $this->_convertUpdateData($validatedData);

        return $this->_shipRepository->updateShip($shipId, $updateData);
    }

    /**
     * Get common input ship data
     *
     * @access private
     * @param array $shipData
     * @return array
     */
    private function _getCommonShipData($shipData)
    {
        return [
            'name' => $shipData['txt-ship-name'],
            'company_id' => $shipData['slb-company'],
            'imo_number' => $shipData['txt-imo-number'],
            'mmsi_number' => $shipData['txt-mmsi-number'],
            'nation_id' => $shipData['nation-id'],
            'classification_id' => $shipData['slb-classification'],
            'register_number' => $shipData['txt-register-number'],
            'type_id' => $shipData['slb-ship-type'],
            'height' => $shipData['txt-ship-length'],
            'width' => $shipData['txt-ship-width'],
            'water_draft' => $shipData['txt-water-draft'],
            'total_weight_ton' => $shipData['txt-total-weight-ton'],
            'total_ton' => $shipData['txt-weight-ton'],
            'member_number' => $shipData['txt-member-number'],
            'remark' => $shipData['txt-remark'],
            'url_1' => $shipData['txt-url-1'],
            'url_2' => $shipData['txt-url-2'],
            'url_3' => $shipData['txt-url-3'],
        ];
    }

    /**
     * Convert data to insert
     *
     * @access private
     * @param array $commonData
     * @return array
     */
    private function _convertInsertData($commonData)
    {
        $data = $this->_getCommonShipData($commonData);

        $createData = [
            'created_by' => auth()->id(),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        return array_merge($data, $createData);
    }

    /**
     * Convert data to update
     *
     * @access private
     * @param array $commonData
     * @return array
     */
    private function _convertUpdateData($commonData)
    {
        $data = $this->_getCommonShipData($commonData);

        $updateData = [
            'updated_by' => auth()->id(),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        return array_merge($data, $updateData);
    }

    /**
     * Check exist ship name
     *
     * @param string $name
     * @return bool
     */
    public function checkExistShipName($name)
    {
        return $this->_shipRepository->checkExistShipName($name);
    }

    /**
     * Check exist ship ImoNumber
     *
     * @param string $imoNumber
     * @return bool
     */
    public function checkExistShipImoNumber($imoNumber)
    {
        return $this->_shipRepository->checkExistShipImoNumber($imoNumber);
    }

    /**
     * Get edit ship data by id
     *
     * @param int $shipId
     * @return array
     */
    public function getEditShipData($shipId)
    {
        return $this->_shipRepository->getEditShipData($shipId);
    }
}
