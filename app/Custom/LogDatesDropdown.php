<?php namespace App\Custom;

class LogDatesDropdown {


    private $_dates_submitted;
    private $_date_limit;


    /**
     * Construct
     * @param integer $date_limit    Number of days back to fetch
     */
    public function __construct( LogDates $log_dates ) {

        $this->_date_limit = $log_dates->date_limit;
        $this->_dates_submitted = $log_dates->dates_submitted;

    }


    /**
     * Compare recent dates to those already logged to the DB
     * @param  integer $index    Number of days previous to current date
     * @return integer           Valid unlogged dates
     */
    private function _populate_unlogged_dates( $index ) {

        $is_logged_date = strtotime( date( 'Y-m-d', time() - (24 * 60 * 60) * $index ) );
        foreach ( $this->_dates_submitted as $obj_date ) {
            if ( $is_logged_date == strtotime( $obj_date->date ) ) return;
        }

        // date is not logged, so return it to include in the dropdown
        return $is_logged_date;

    }


    /**
     * Gather valid unlogged date options and create the dropdown
     * @return string    Select field options
     */
    public function create() {

        $options = '<option value="NULL"></option>';

        for ( $i=0 ; $i<$this->_date_limit ; $i++ ) {

            // is valid unlogged date?
            $value = $this->_populate_unlogged_dates( $i );
            if ( ! is_null( $value ) ) {

                // if so, add it as an option to the bootstrap dropdown
                $option_value = date( 'Y-m-d', $value );
                $option_display = date( 'm.d.y (D)', $value );

                $options .= '<option value="' . $option_value . '">' . $option_display . '</option>';

            }

        }

        return $options;

    }

}
