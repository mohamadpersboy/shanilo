<?php

return [
    /*--------------------------------------------------------
     * Default attribute for table element
     * -------------------------------------------------------
     */
    'table' => [
        /**
         * Set Attribute for div parent of table
         */
        'parentTableAttribute' => ["class" => "table-responsive"],
        /**
         * Set Attribute for table
         */
        'tableAttribute' => ["class" => "table table-striped"],
        /**
         * Set Attribute for thead of table
         */
        'theadAttribute' => [],
        /**
         * Set Attribute for tbody of table
         */
        'tbodyAttribute' => [],

        /**
         * Set Attribute for any tr of table
         */
        'trAttribute' => [],
        /**
         * Set Attribute tr of table
         */
        'thAttribute' => [],
        /**
         * Set Attribute for any th of table
         */
        'tdAttribute' => [],
        /**
         * Set increment number row for table
         */
        'hasRowIndex' => false,
        /**
         * Set Default message when data empty result
         */
        'messageEmpty' => 'هیچ موردی برای نمایش وجود ندارد! '
    ],


    /*---------------------------------------------------------------------------
     * Default config for excel
     * --------------------------------------------------------------------------
     */
    'excel' => [
        /**
         * Check create excel or no
         */
        'createExcel' => false,
        /**
         * Default file name for excel file
         */
        'fileName' => 'excel',
        /**
         * Default column excel
         */
        'alphabet' => [
            'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M',
            'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
        ],
        /**
         * Default attribute for parent div excel button
         */
        'parentButtonAttr' => ['class' => 'title_style1 fleft margint10'],
        /**
         * Default attribute for button excel
         */
        'buttonExcelAttribute' => ['class' => 'btn btn-info btn-labeled btn-xs mg-bottom-3  mg-left-3','style'=>'margin-bottom:10px'],
        /**
         * Default inner html button export excel
         */
        'innerHtmlButtonExcel' => '<b><i class="icon-file-excel"></i></b> خروجی اکسل',
        /**
         * Default direction Excel
         */
        'excelDirection' => 'rtl',
    ],


    /*---------------------------------------------------------------------------
    * Default config for paginate
    * --------------------------------------------------------------------------
    */
    'paginate' => [
        /**
         * Set default increment row table
         */
        'increment' => 1,
        /**
         * Set default paginate number
         */
        'paginate' => 20,
        /**
         * Set default attribute for patent link paginate
         */
        'parentPaginateAttribute' => ['class' => 'grid_view_paginate'],
    ]

];
