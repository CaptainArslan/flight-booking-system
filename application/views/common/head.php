<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
<meta http-equiv="X-UA-Compatible" content="ie=edge"/>
<title><?php echo $page_title.' - '.$this->title ; ?></title>
<link rel="icon" href="<?php echo base_url('favicon.ico')?>" type="image/x-icon"/>
<link rel="shortcut icon" href="<?php echo base_url('favicon.ico')?>" type="image/x-icon"/>
<link href="<?php echo base_url('assets/css/tabler.min.css')?>" rel="stylesheet"/>
<link href="<?php echo base_url('assets/css/tabler-flags.min.css')?>" rel="stylesheet"/>
<link href="<?php echo base_url('assets/css/tabler-payments.min.css')?>" rel="stylesheet"/>
<link href="<?php echo base_url('assets/css/tabler-vendors.min.css')?>" rel="stylesheet"/>
<link href="<?php echo base_url('assets/css/demo.min.css')?>" rel="stylesheet"/>
<link href="<?php echo base_url('assets/css/icon.css')?>" rel="stylesheet"/>
<link href="<?php echo base_url('assets/css/bootstrap-datetimepicker.min.css')?>" rel="stylesheet"/>
<link href="<?php echo base_url('assets/libs/jqtoast/jquery.toast.min.css')?>" rel="stylesheet">
<link href="<?php echo base_url('assets/libs/sweetalert/sweetalert2.min.css')?>" rel="stylesheet">
<?php
    if(isset($css) && count($css) > 0){
        foreach ($css as $key => $href) {
?>
    <link href="<?php echo base_url($href)?>" rel="stylesheet"/>
<?php
        }
    }
?>
<style>
    body { display: none;}
    .typeahead {
        background-color: #fff;
        margin: 0 !important
    }

    .tt-query {
        box-shadow: 0 1px 1px rgba(0, 0, 0, .075) inset
    }

    .tt-hint {
        color: #bbb
    }

    .tt-dropdown-menu {
        background: #fff none repeat scroll 0 0;
        border: 1px solid #e6e6e6;
        color: #000;
        max-height: 200px;
        overflow-y: auto;
        text-align: left !important;
        white-space: nowrap;
        width: 100%;
        z-index: 9999 !important
    }

    .tt-suggestion {
        border-left: 1px solid #e6e6e6;
        border-right: 1px solid #e6e6e6;
        border-bottom: 1px solid #e6e6e6;
        font-size: 12px;
        line-height: 1em;
        padding: 10px;
        cursor: pointer
    }

    .tt-suggestion .tt-is-under-cursor {
        background: #fff none repeat scroll 0 0;
        color: #000;
        cursor: pointer
    }

    .tt-suggestion p {
        margin: 0
    }
    input,select,textarea {
        border-radius: 0px !important;
        background-color: #fff !important;
    }
    input.parsley-success,
    select.parsley-success,
    textarea.parsley-success {
        color: #026e03;
        background-color: #fff;
        border: 1px solid #026e03
    }

    input.parsley-error,
    select.parsley-error,
    textarea.parsley-error {
        color: #e46a76;
        background-color: #fff;
        border: 1px solid #e46a76
    }

    .parsley-errors-list {
        margin: 5px 0;
        padding: 0;
        list-style-type: none;
        font-size: .9em;
        line-height: .9em;
        opacity: 0;
        color: #e46a76;
        transition: all .3s ease-in;
        -o-transition: all .3s ease-in;
        -moz-transition: all .3s ease-in;
        -webkit-transition: all .3s ease-in
    }

    .parsley-errors-list.filled {
        opacity: 1
    }
    .tox-editor-container{
        padding: 0px !important;
    }
    .cust-toast{
        position: absolute;
        top: 30px;
        right: 20px;
    }
    .table thead th{
        --tblr-table-accent-bg: #232e3c !important;
        color: #fff !important;
    }
    .text-right{
        text-align: right !important;
    }
    .datetimepicker td, .datetimepicker th{
        padding: 5px 6px !important;
        font-size: 12px !important;
    }
    .nav-tabs .nav-link{
        margin-right: 10px;
        background: #ccc9c9;
    }
    .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
        color: #fff;
        background-color: #232e3c;
        border-color: #e7eaef #e7eaef #232e3c;
    }
    .nav-tabs .nav-link.active{
        border-color:  #232e3c;
    }
    .tab-pane {
        padding: 10px;
        border: 2px solid #232e3c;
    }
    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
    }
    /* Firefox */
    input[type=number] {
    -moz-appearance: textfield;
    }
    .trans_alert{
        display: none;
    }
    .mr-10{
        margin-right: 10px !important;
    }
    .sidebardivider{
        background: #41556f;
        border-radius: 0px !important;
        color: #fff;
    }
    .scrollbar-custom, html  {
    scrollbar-width: thin;
    scrollbar-color: #3f526b #b0b7c4;
    }
    .scrollbar-custom::-webkit-scrollbar, html::-webkit-scrollbar  {
    width: 8px;
    height: 8px;
    }
    .scrollbar-custom::-webkit-scrollbar-track, html::-webkit-scrollbar-track  {
    background-clip: content-box;
    border: 2px solid transparent;
    }
    .scrollbar-custom::-webkit-scrollbar-thumb, html::-webkit-scrollbar-thumb  {
    background-color: #ff7f00;
    }
    .scrollbar-custom::-webkit-scrollbar-thumb:hover, html::-webkit-scrollbar-thumb:hover  {
    background-color: #e67200;
    }
    .scrollbar-custom::-webkit-scrollbar-corner, .scrollbar-1::-webkit-scrollbar-track, html::-webkit-scrollbar-corner, html::-webkit-scrollbar-track  {
    background-color: #b0b7c4;
    }
</style>