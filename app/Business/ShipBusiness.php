<?php

/**
 * Ship management Business
 *
 * @package App\Business
 * @author Rikkei.quyenl
 * @date 2018/07/05
 */

namespace App\Business;

use App\Common\Constant;
use App\Repositories\Ship\ShipInterface;

/**
 * Class ShipBusiness Handle business related ship
 */
class ShipBusiness {

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
    public function __construct(ShipInterface $shipInterface) {
        $this->_shipRepository = $shipInterface;
    }

    /**
     * Get list ship data
     *
     * @param null|string $filterColumn default null
     * @param int $perPage
     * @param null|int $orderBy ASC: 0, null | DESC: 1
     * @param int $companyId
     * @return object
     */
    public function getListShip($filterColumn = null, $perPage = Constant::PAGINATION_PER_PAGE, $orderBy = null, $companyId = null) {
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
        $orderBy = $orderBy ? 'DESC' : 'ASC';

        return $query->orderBy($this->_convertToColumn($filterColumn), $orderBy)
                        ->orderBy('m_ship.id', $orderBy)
                        ->paginate($perPage);
    }

    /**
     * Business filter company
     *
     * @param array $filters conditions filter
     * @param int $pagination total record per page
     * @param array $option sort with column and order by
     * @return object
     */
    public function filterCompany($filters, $pagination = Constant::PAGINATION_PER_PAGE, $option = []) {
        // Check pagination
        if (!in_array($pagination, Constant::ARY_PAGINATION_PER_PAGE)) {
            $pagination = Constant::PAGINATION_PER_PAGE;
        }

        // Get filter search data
        $filters = $this->_getFilterData($filters);

        // Check order by is descending or ascending
        $option['orderBy'] = $option['orderBy'] ? 'DESC' : 'ASC';

        return $this->_shipRepository
                        ->getCommonListShipQuery()
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
    private function _convertToColumn($name = null) {
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
    private function _getFilterData($params) {
        // Init empty array value
        $data = [];

        // Filter if have request value, empty in other case
        $data['filter-ship-name'] = !empty($params['filter-ship-name']) ? $params['filter-ship-name'] : '';
        $data['filter-company'] = !empty($params['filter-company']) ? $params['filter-company'] : '';
        $data['filter-classification'] = !empty($params['filter-classification']) ? $params['filter-classification'] : '';
        $data['filter-ship-type'] = !empty($params['filter-ship-type']) ? $params['filter-ship-type'] : '';
        $data['filter-imo-number'] = !empty($params['filter-imo-number']) ? $params['filter-imo-number'] : '';
        $data['filter-ship-nation'] = !empty($params['filter-ship-nation']) ? $params['filter-ship-nation'] : '';
        $data['filter-service-name'] = !empty($params['filter-service-name']) ? $params['filter-service-name'] : '';

        return $data;
    }

    /*
     * Business init search ship
     * @access public
     * @param int companyId
     * @return data query
     */

    public function initSearchShip($companyId) {

        $dataQuery = $this->_shipRepository->getListShip($companyId);

        return $dataQuery;
    }

    /*
     * Business init search ship
     * @access public
     * @param int companyId
     * @return data query
     */

    public function searchShip($companyId, $idShipSearch, $nameShipSearch) {

        $dataQuery = $this->_shipRepository->searchListShip($companyId,$idShipSearch,$nameShipSearch);

        return $dataQuery;
    }

}
