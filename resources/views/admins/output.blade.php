@extends('zlayouts.main')
{{-- @section('activeoutput', 'active fw-bold text-primary-emphasis')
@section('show_laper', 'show')
@section('collapsed_laper', 'bg-light active collapsed')
@section('aria_laper', 'true') --}}

@section('container')
<!-- Content -->
<div class="content">
    <!-- Animated -->
    <div class="animated fadeIn">
        <!--  Search data  -->
        <div class="row justify-content-center">
            <div class="col-12 mb-2">
                <div class="card">
                    <div class="card-header">
                        <h6 class="box-title">Search Data </h6>
                        {{-- <div class="text-muted font-italic"><small>Please fill the box if you want to know</small></div> --}}
                    </div>
                    <div class="card-body card-block">
                        <div class="row form-group">
                            <div class="col-2">
                                <div class="card">
                                    <div class="bg-warning-subtle text-center"><small>Start Date (mm/dd/yyyy)</small></div>
                                    <input type="date" class="form-control form-control-sm" name="stdate" id="stdate" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="card">
                                    <div class="bg-warning-subtle text-center"><small>End Date (mm/dd/yyyy)</small></div>
                                    <input type="date" class="form-control form-control-sm" name="endate" id="endate" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="card">
                                    <div class="bg-warning-subtle text-center"><small>BC Type</small></div>
                                    {{-- <input type="text" class="form-control form-control-sm text-uppercase" placeholder="please fill in" name="jnsdokbc" id="jnsdokbc" autocomplete="off"> --}}
                                    <select class="form-control form-control-sm text-uppercase" name="jnsdokbc" id="jnsdokbc">
                                        <option value=''></option>
                                        <option value='25BC'> 25BC </option>
                                        <option value='261BC'> 261BC </option>
                                        <option value='27BC'> 27BC </option>
                                        <option value='30BC'> 30BC </option>
                                        <option value='41BC'> 41BC </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="card">
                                    <div class="bg-warning-subtle text-center"><small>BC Number</small></div>
                                    <input type="text" class="form-control form-control-sm text-uppercase" placeholder="please fill in" name="nodokbc" id="nodokbc" autocomplete="off">
                                    {{-- <select class="form-control form-control-sm text-uppercase" name="jnsdokbc" id="jnsdokbc">
                                        <option> 23BC </option>
                                        <option> 26BC </option>
                                        <option> 27BC </option>
                                        <option> 27GB </option>
                                        <option> 40BC </option>
                                        <option> 262BC </option>
                                    </select> --}}
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="card">
                                    <div class="bg-warning-subtle text-center"><small>Part Number</small></div>
                                    <input type="text" class="form-control form-control-sm text-uppercase" placeholder="please fill in" name="partno" id="partno" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-12 mt-2">
                                <div class="btn-toolbar justify-content-between" role="toolbar" aria-label="Toolbar with button groups">
                                    <div>
                                        &nbsp;
                                    </div>
                                    <div class="btn-group" role="group" aria-label="First group">
                                        <button type="reset" class="btn btn-warning btn-sm" id="btn_reset">Reset Search</button>
                                        <button type="button" class="btn btn-secondary btn-sm" id="btn_download">Download</button>
                                        <button type="button" class="btn btn-success btn-sm" id="btn_cari">Search</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--  Table data  -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div style="float:left">
                            <strong class="card-title">Data Pengeluaran <p class="card-text text-muted" id="spn_totalcount"></p></strong>
                            <div id="writeloading"></div>
                        </div>
                        <div style="float:right">
                            <div id="writepagination"></div>
                        </div>
                    </div>
                    <div class="table-stats order-table ov-h">
                        <table class="table table-striped table-hover">
                            <thead class="table-bordered">
                                <tr>
                                    <th class=" text-center" rowspan="2">No</th>
                                    <th class=" text-center" colspan="3">Dokumen Pabean</th>
                                    <th class=" text-center" colspan="3">Bukti Pengeluaran Barang (BPB)</th>
                                    {{-- <th class="">Invoice Date</th> --}}
                                    <th class=" text-center" rowspan="2">Nama Pemasok</th>
                                    <th class=" text-center" rowspan="2">Kode Barang</th>
                                    <th class=" text-center" rowspan="2">Nama Barang</th>
                                    <th class=" text-center" rowspan="2">Jumlah</th>
                                    <th class=" text-center" rowspan="2">Satuan</th>
                                    <th class=" text-center" rowspan="2">Kode Valuta</th>
                                    <th class=" text-center" rowspan="2">Nilai</th>
                                    {{-- <th class=" text-center" rowspan="2">Create by</th> --}}
                                </tr>
                                <tr>
                                    <th class=" text-center">Jenis BC</th>
                                    <th class=" text-center">No. Daftar</th>
                                    <th class=" text-center">Tanggal Daftar</th>
                                    <th class=" text-center">No. BPB</th>
                                    <th class=" text-center">Tanggal BPB</th>
                                    <th class=" text-center">No Invoice</th>
                                </tr>
                            </thead>
                            {{-- <thead>
                                <tr>
                                    <th class="align-middle">No</th>
                                    <th class="align-middle">BC Type</th>
                                    <th class="align-middle">BC Number</th>
                                    <th class="align-middle">BC Date</th>
                                    <th class="align-middle">Outgoing No</th>
                                    <th class="align-middle">Outgoing Date</th>
                                    <th class="align-middle">Invoice No</th>
                                    <th class="align-middle">Invoice Date</th>
                                    <th class="align-middle">Supplier</th>
                                    <th class="align-middle col-sm-2">Part No</th>
                                    <th class="align-middle">Part Name</th>
                                    <th class="align-middle">QTY</th>
                                    <th class="align-middle">Unit</th>
                                    <th class="align-middle">Price</th>
                                    <th class="align-middle">Currency</th>
                                    <th class="align-middle">Create by</th>
                                </tr>
                            </thead> --}}
                            <tbody>
                            </tbody>
                        </table>
                    </div> <!-- /.table-stats -->
                    <div class="card-footer"></div>
                </div>
            </div><!-- /# column -->
        </div>
        <!--  /Table data -->
        <div class="clearfix"></div>
    </div>
    <!-- .animated -->
</div>
<!-- /.content -->
@endsection

@section('stylejavascript')
<script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
<script>
//  ***
//  load data

function forceHttps(url) {
    if (url.startsWith('http://')) {
        return 'https://' + url.substring(7); // buang "http://"
    }
    return url; // kalau sudah https, tidak diubah
}

var url = forceHttps("{{ route('output.loaddata') }}");
// var url = "{{ route('output.loaddata') }}";

function loaddata()
{
    //  variable
    var stdate      = $("#stdate").val().replace(/-/g, "");
    var endate      = $("#endate").val().replace(/-/g, "");
    var jnsdokbc    = $("#jnsdokbc").val();
    var nodokbc     = $("#nodokbc").val();
    var partno      = $("#partno").val();
    $("#loadingdata").remove();
    $("#writeloading").append("<div id='loadingdata' class='text-muted font-italic'> <img src='./zlayouts/images/loadingdata.gif' height='20'><small>&nbsp;Loading data...</small> </div>");
    $.ajax({
        url     : url,
        method  : 'GET',
        data    : { stdate:stdate, endate:endate, jnsdokbc:jnsdokbc, nodokbc:nodokbc, partno:partno },
        dataType: 'json',
        success : function(data)
        {
            var valraquo = data.halamanAktif + 1;
            $("#loadingdata").remove();
            $('tbody').html(data.table_data);
            //  total count
            if(data.totalcount == 1)
            {
                $("#spn_totalcount").text("Total data "+data.totalcount+" record");
            }
            else if(data.totalcount > 1)
            {
                $("#spn_totalcount").text("Total data "+data.totalcount+" records");
            }
            else
            {
                $("#spn_totalcount").text("Data nothing");
            }
            //  pagination
            if(data.halamanAktif === data.jumlahHalaman)
            {
                $("#navigation").remove();
                $("#writepagination").append(""
                + "<div id='navigation'>"
                    + "<nav class='pagination-outer' aria-label='Page navigation'>"
                    + "<ul class='pagination pagination-sm'>"
                        + "<li class='page-item disabled'><a href='#' class='page-link' aria-label='First'><span aria-hidden='true' class='text-muted'>First</span></a></li>"
                        + "<li class='page-item disabled'><a href='#' class='page-link' aria-label='Previous'><span aria-hidden='true' class='text-muted'>«</span></a></li>"
                        + "<li class='page-item disabled active'><a href='#' class='page-link' aria-label='First'><span aria-hidden='true'>"+data.halamanAktif+" of about "+data.jumlahHalaman+" page</span></a></li>"
                        + "<li class='page-item disabled'><a href='#' class='page-link' aria-label='Next'><span aria-hidden='true' class='text-muted'>»</span></a></li>"
                        + "<li class='page-item disabled'><a href='#' class='page-link' aria-label='Last'><span aria-hidden='true' class='text-muted'>Last</span></a></li>"
                    + "</ul>"
                    + "</nav>"
                + "</div>");
            }
            else
            {
                $("#navigation").remove();
                $("#writepagination").append(""
                + "<div id='navigation'>"
                    + "<nav class='pagination-outer' aria-label='Page navigation'>"
                    + "<ul class='pagination pagination-sm'>"
                        + "<li class='page-item disabled'><a href='#' class='page-link' aria-label='First'><span aria-hidden='true' class='text-muted'>First</span></a></li>"
                        + "<li class='page-item disabled'><a href='#' class='page-link' aria-label='Previous'><span aria-hidden='true' class='text-muted'>«</span></a></li>"
                        + "<li class='page-item disabled active'><a href='#' class='page-link' aria-label='First'><span aria-hidden='true'>"+data.halamanAktif+" of about "+data.jumlahHalaman+" page</span></a></li>"
                        + "<li class='page-item '><a href='#' class='page-link' aria-label='Next' onclick=\'raquo("+(valraquo)+")\'><span aria-hidden='true'>»</span></a></li>"
                        + "<li class='page-item '><a href='#' class='page-link' aria-label='Last' onclick=\'last("+data.jumlahHalaman+")\'><span aria-hidden='true'>Last</span></a></li>"
                    + "</ul>"
                    + "</nav>"
                + "</div>");
            }
        }
    });
}

function search()
{
    //  variable
    var stdate      = $("#stdate").val().replace(/-/g, "");
    var endate      = $("#endate").val().replace(/-/g, "");
    var jnsdokbc    = $("#jnsdokbc").val();
    var nodokbc     = $("#nodokbc").val();
    var partno      = $("#partno").val();
    $("#loadingdata").remove();
    $("#writeloading").append("<div id='loadingdata' class='text-muted font-italic'> <img src='./zlayouts/images/loadingdata.gif' height='20'><small>&nbsp;Loading data...</small> </div>");
    $.ajax({
        url     : url,
        method  : 'GET',
        data    : { stdate:stdate, endate:endate, jnsdokbc:jnsdokbc, nodokbc:nodokbc, partno:partno },
        dataType: 'json',
        success : function(data)
        {
            var vallaquo = data.halamanAktif - 1;
            var valraquo = data.halamanAktif + 1;
            $("#loadingdata").remove();
            $('tbody').html(data.table_data);
            //  total count
            if(data.totalcount == 1)
            {
                $("#spn_totalcount").text("Total data "+data.totalcount+" record");
            }
            else if(data.totalcount > 1)
            {
                $("#spn_totalcount").text("Total data "+data.totalcount+" records");
            }
            else
            {
                $("#spn_totalcount").text("Data nothing");
            }
            //  pagination
            if(data.halamanAktif > 1)
            {
                if(data.halamanAktif < data.jumlahHalaman)
                {
                    $("#navigation").remove();
                    $("#writepagination").append(""
                    + "<div id='navigation'>"
                        + "<nav class='pagination-outer' aria-label='Page navigation'>"
                        + "<ul class='pagination pagination-sm'>"
                            + "<li class='page-item '><a href='#' class='page-link' aria-label='First' onclick=\'first(1)\'><span aria-hidden='true'>First</span></a></li>"
                            + "<li class='page-item '><a href='#' class='page-link' aria-label='Previous' onclick=\'laquo("+(vallaquo)+")\'><span aria-hidden='true'>«</span></a></li>"
                            + "<li class='page-item disabled active'><a href='#' class='page-link' aria-label='First'><span aria-hidden='true'>"+data.halamanAktif+" of about "+data.jumlahHalaman+" page</span></a></li>"
                            + "<li class='page-item '><a href='#' class='page-link' aria-label='Next' onclick=\'raquo("+(valraquo)+")\'><span aria-hidden='true'>»</span></a></li>"
                            + "<li class='page-item '><a href='#' class='page-link' aria-label='Last' onclick=\'last("+data.jumlahHalaman+")\'><span aria-hidden='true'>Last</span></a></li>"
                        + "</ul>"
                        + "</nav>"
                    + "</div>");
                }
                else
                {
                    $("#navigation").remove();
                    $("#writepagination").append(""
                    + "<div id='navigation'>"
                        + "<nav class='pagination-outer' aria-label='Page navigation'>"
                        + "<ul class='pagination pagination-sm'>"
                            + "<li class='page-item '><a href='#' class='page-link' aria-label='First' onclick=\'first(1)\'><span aria-hidden='true'>First</span></a></li>"
                            + "<li class='page-item '><a href='#' class='page-link' aria-label='Previous' onclick=\'laquo("+(vallaquo)+")\'><span aria-hidden='true'>«</span></a></li>"
                            + "<li class='page-item disabled active'><a href='#' class='page-link' aria-label='First'><span aria-hidden='true'>"+data.halamanAktif+" of about "+data.jumlahHalaman+" page</span></a></li>"
                            + "<li class='page-item disabled'><a href='#' class='page-link' aria-label='Next'><span aria-hidden='true' class='text-muted'>»</span></a></li>"
                            + "<li class='page-item disabled'><a href='#' class='page-link' aria-label='Last'><span aria-hidden='true' class='text-muted'>Last</span></a></li>"
                        + "</ul>"
                        + "</nav>"
                    + "</div>");
                }
            }
            else
            {
                if(data.halamanAktif === data.jumlahHalaman)
                {
                    $("#navigation").remove();
                    $("#writepagination").append(""
                    + "<div id='navigation'>"
                        + "<nav class='pagination-outer' aria-label='Page navigation'>"
                        + "<ul class='pagination pagination-sm'>"
                            + "<li class='page-item disabled'><a href='#' class='page-link' aria-label='First'><span aria-hidden='true' class='text-muted'>First</span></a></li>"
                            + "<li class='page-item disabled'><a href='#' class='page-link' aria-label='Previous'><span aria-hidden='true' class='text-muted'>«</span></a></li>"
                            + "<li class='page-item disabled active'><a href='#' class='page-link' aria-label='First'><span aria-hidden='true'>"+data.halamanAktif+" of about "+data.jumlahHalaman+" page</span></a></li>"
                            + "<li class='page-item disabled'><a href='#' class='page-link' aria-label='Next'><span aria-hidden='true' class='text-muted'>»</span></a></li>"
                            + "<li class='page-item disabled'><a href='#' class='page-link' aria-label='Last'><span aria-hidden='true' class='text-muted'>Last</span></a></li>"
                        + "</ul>"
                        + "</nav>"
                    + "</div>");
                }
                else
                {
                    $("#navigation").remove();
                    $("#writepagination").append(""
                    + "<div id='navigation'>"
                        + "<nav class='pagination-outer' aria-label='Page navigation'>"
                        + "<ul class='pagination pagination-sm'>"
                            + "<li class='page-item disabled'><a href='#' class='page-link' aria-label='First'><span aria-hidden='true' class='text-muted'>First</span></a></li>"
                            + "<li class='page-item disabled'><a href='#' class='page-link' aria-label='Previous'><span aria-hidden='true' class='text-muted'>«</span></a></li>"
                            + "<li class='page-item disabled active'><a href='#' class='page-link' aria-label='First'><span aria-hidden='true'>"+data.halamanAktif+" of about "+data.jumlahHalaman+" page</span></a></li>"
                            + "<li class='page-item '><a href='#' class='page-link' aria-label='Next' onclick=\'raquo("+(valraquo)+")\'><span aria-hidden='true'>»</span></a></li>"
                            + "<li class='page-item '><a href='#' class='page-link' aria-label='Last' onclick=\'last("+data.jumlahHalaman+")\'><span aria-hidden='true'>Last</span></a></li>"
                        + "</ul>"
                        + "</nav>"
                    + "</div>");
                }
            }
        }
    });
}

//  ***
//  function pagination
var urlpaging = "{{ route('output.pagination') }}";
function first(jumlahHalaman)
{
    //  variable
    var stdate      = $("#stdate").val().replace(/-/g, "");
    var endate      = $("#endate").val().replace(/-/g, "");
    var jnsdokbc    = $("#jnsdokbc").val();
    var nodokbc     = $("#nodokbc").val();
    var partno      = $("#partno").val();
    $("#loadingdata").remove();
    $("#writeloading").append("<div id='loadingdata' class='text-muted font-italic'> <img src='./zlayouts/images/loadingdata.gif' height='20'><small>&nbsp;Loading data...</small> </div>");
    $.ajax({
        url     : urlpaging,
        method  : 'GET',
        data    : { stdate:stdate, endate:endate, jnsdokbc:jnsdokbc, nodokbc:nodokbc, partno:partno, jumlahHalaman: jumlahHalaman },
        dataType: 'json',
        success : function(data)
        {
            var valraquo = data.halamanAktif + 1;
            $("#loadingdata").remove();
            $('tbody').html(data.table_data);
            //  total count
            if(data.totalcount == 1)
            {
                $("#spn_totalcount").text("Total data "+data.totalcount+" record");
            }
            else if(data.totalcount > 1)
            {
                $("#spn_totalcount").text("Total data "+data.totalcount+" records");
            }
            else
            {
                $("#spn_totalcount").text("Data nothing");
            }
            //  pagination
            $("#navigation").remove();
            $("#writepagination").append(""
            + "<div id='navigation'>"
                + "<nav class='pagination-outer' aria-label='Page navigation'>"
                + "<ul class='pagination pagination-sm'>"
                    + "<li class='page-item disabled'><a href='#' class='page-link' aria-label='First'><span aria-hidden='true' class='text-muted'>First</span></a></li>"
                    + "<li class='page-item disabled'><a href='#' class='page-link' aria-label='Previous'><span aria-hidden='true' class='text-muted'>«</span></a></li>"
                    + "<li class='page-item disabled active'><a href='#' class='page-link' aria-label='First'><span aria-hidden='true'>"+data.halamanAktif+" of about "+data.jumlahHalaman+" page</span></a></li>"
                    + "<li class='page-item '><a href='#' class='page-link' aria-label='Next' onclick=\'raquo("+(valraquo)+")\'><span aria-hidden='true'>»</span></a></li>"
                    + "<li class='page-item '><a href='#' class='page-link' aria-label='Last' onclick=\'last("+data.jumlahHalaman+")\'><span aria-hidden='true'>Last</span></a></li>"
                + "</ul>"
                + "</nav>"
            + "</div>");
        }
    });
}

function laquo(jumlahHalaman)
{
    //  variable
    var stdate      = $("#stdate").val().replace(/-/g, "");
    var endate      = $("#endate").val().replace(/-/g, "");
    var jnsdokbc    = $("#jnsdokbc").val();
    var nodokbc     = $("#nodokbc").val();
    var partno      = $("#partno").val();
    $("#loadingdata").remove();
    $("#writeloading").append("<div id='loadingdata' class='text-muted font-italic'> <img src='./zlayouts/images/loadingdata.gif' height='20'><small>&nbsp;Loading data...</small> </div>");
    $.ajax({
        url     : urlpaging,
        method  : 'GET',
        data    : { stdate:stdate, endate:endate, jnsdokbc:jnsdokbc, nodokbc:nodokbc, partno:partno, jumlahHalaman: jumlahHalaman },
        dataType: 'json',
        success : function(data)
        {
            var vallaquo = data.halamanAktif - 1;
            var valraquo = data.halamanAktif + 1;
            $("#loadingdata").remove();
            $('tbody').html(data.table_data);
            //  total count
            if(data.totalcount == 1)
            {
                $("#spn_totalcount").text("Total data "+data.totalcount+" record");
            }
            else if(data.totalcount > 1)
            {
                $("#spn_totalcount").text("Total data "+data.totalcount+" records");
            }
            else
            {
                $("#spn_totalcount").text("Data nothing");
            }
            //  pagination
            if(data.halamanAktif > 1)
            {
                $("#navigation").remove();
                $("#writepagination").append(""
                + "<div id='navigation'>"
                    + "<nav class='pagination-outer' aria-label='Page navigation'>"
                    + "<ul class='pagination pagination-sm'>"
                        + "<li class='page-item '><a href='#' class='page-link' aria-label='First' onclick=\'first(1)\'><span aria-hidden='true'>First</span></a></li>"
                        + "<li class='page-item '><a href='#' class='page-link' aria-label='Previous' onclick=\'laquo("+(vallaquo)+")\'><span aria-hidden='true'>«</span></a></li>"
                        + "<li class='page-item disabled active'><a href='#' class='page-link' aria-label='First'><span aria-hidden='true'>"+data.halamanAktif+" of about "+data.jumlahHalaman+" page</span></a></li>"
                        + "<li class='page-item '><a href='#' class='page-link' aria-label='Next' onclick=\'raquo("+(valraquo)+")\'><span aria-hidden='true'>»</span></a></li>"
                        + "<li class='page-item '><a href='#' class='page-link' aria-label='Last' onclick=\'last("+data.jumlahHalaman+")\'><span aria-hidden='true'>Last</span></a></li>"
                    + "</ul>"
                    + "</nav>"
                + "</div>");
            }
            else
            {
                $("#navigation").remove();
                $("#writepagination").append(""
                + "<div id='navigation'>"
                    + "<nav class='pagination-outer' aria-label='Page navigation'>"
                    + "<ul class='pagination pagination-sm'>"
                        + "<li class='page-item disabled'><a href='#' class='page-link' aria-label='First'><span aria-hidden='true' class='text-muted'>First</span></a></li>"
                        + "<li class='page-item disabled'><a href='#' class='page-link' aria-label='Previous'><span aria-hidden='true' class='text-muted'>«</span></a></li>"
                        + "<li class='page-item disabled active'><a href='#' class='page-link' aria-label='First'><span aria-hidden='true'>"+data.halamanAktif+" of about "+data.jumlahHalaman+" page</span></a></li>"
                        + "<li class='page-item '><a href='#' class='page-link' aria-label='Next' onclick=\'raquo("+(valraquo)+")\'><span aria-hidden='true'>»</span></a></li>"
                        + "<li class='page-item '><a href='#' class='page-link' aria-label='Last' onclick=\'last("+data.jumlahHalaman+")\'><span aria-hidden='true'>Last</span></a></li>"
                    + "</ul>"
                    + "</nav>"
                + "</div>");
            }
        }
    });
}

function raquo(jumlahHalaman)
{
    //  variable
    var stdate      = $("#stdate").val().replace(/-/g, "");
    var endate      = $("#endate").val().replace(/-/g, "");
    var jnsdokbc    = $("#jnsdokbc").val();
    var nodokbc     = $("#nodokbc").val();
    var partno      = $("#partno").val();
    $("#loadingdata").remove();
    $("#writeloading").append("<div id='loadingdata' class='text-muted font-italic'> <img src='./zlayouts/images/loadingdata.gif' height='20'><small>&nbsp;Loading data...</small> </div>");
    $.ajax({
        url     : urlpaging,
        method  : 'GET',
        data    : { stdate:stdate, endate:endate, jnsdokbc:jnsdokbc, nodokbc:nodokbc, partno:partno, jumlahHalaman: jumlahHalaman },
        dataType: 'json',
        success : function(data)
        {
            var vallaquo = data.halamanAktif - 1;
            var valraquo = data.halamanAktif + 1;
            $("#loadingdata").remove();
            $('tbody').html(data.table_data);
            //  total count
            if(data.totalcount == 1)
            {
                $("#spn_totalcount").text("Total data "+data.totalcount+" record");
            }
            else if(data.totalcount > 1)
            {
                $("#spn_totalcount").text("Total data "+data.totalcount+" records");
            }
            else
            {
                $("#spn_totalcount").text("Data nothing");
            }
            //  pagination
            if(data.halamanAktif < data.jumlahHalaman)
            {
                $("#navigation").remove();
                $("#writepagination").append(""
                + "<div id='navigation'>"
                    + "<nav class='pagination-outer' aria-label='Page navigation'>"
                    + "<ul class='pagination pagination-sm'>"
                        + "<li class='page-item '><a href='#' class='page-link' aria-label='First' onclick=\'first(1)\'><span aria-hidden='true'>First</span></a></li>"
                        + "<li class='page-item '><a href='#' class='page-link' aria-label='Previous' onclick=\'laquo("+(vallaquo)+")\'><span aria-hidden='true'>«</span></a></li>"
                        + "<li class='page-item disabled active'><a href='#' class='page-link' aria-label='First'><span aria-hidden='true'>"+data.halamanAktif+" of about "+data.jumlahHalaman+" page</span></a></li>"
                        + "<li class='page-item '><a href='#' class='page-link' aria-label='Next' onclick=\'raquo("+(valraquo)+")\'><span aria-hidden='true'>»</span></a></li>"
                        + "<li class='page-item '><a href='#' class='page-link' aria-label='Last' onclick=\'last("+data.jumlahHalaman+")\'><span aria-hidden='true'>Last</span></a></li>"
                    + "</ul>"
                    + "</nav>"
                + "</div>");
            }
            else
            {
                $("#navigation").remove();
                $("#writepagination").append(""
                + "<div id='navigation'>"
                    + "<nav class='pagination-outer' aria-label='Page navigation'>"
                    + "<ul class='pagination pagination-sm'>"
                        + "<li class='page-item '><a href='#' class='page-link' aria-label='First' onclick=\'first(1)\'><span aria-hidden='true'>First</span></a></li>"
                        + "<li class='page-item '><a href='#' class='page-link' aria-label='Previous' onclick=\'laquo("+(vallaquo)+")\'><span aria-hidden='true'>«</span></a></li>"
                        + "<li class='page-item disabled active'><a href='#' class='page-link' aria-label='First'><span aria-hidden='true'>"+data.halamanAktif+" of about "+data.jumlahHalaman+" page</span></a></li>"
                        + "<li class='page-item disabled'><a href='#' class='page-link' aria-label='Next'><span aria-hidden='true' class='text-muted'>»</span></a></li>"
                        + "<li class='page-item disabled'><a href='#' class='page-link' aria-label='Last'><span aria-hidden='true' class='text-muted'>Last</span></a></li>"
                    + "</ul>"
                    + "</nav>"
                + "</div>");
            }
        }
    });
}

function last(jumlahHalaman)
{
    //  variable
    var stdate      = $("#stdate").val().replace(/-/g, "");
    var endate      = $("#endate").val().replace(/-/g, "");
    var jnsdokbc    = $("#jnsdokbc").val();
    var nodokbc     = $("#nodokbc").val();
    var partno      = $("#partno").val();
    $("#loadingdata").remove();
    $("#writeloading").append("<div id='loadingdata' class='text-muted font-italic'> <img src='./zlayouts/images/loadingdata.gif' height='20'><small>&nbsp;Loading data...</small> </div>");
    $.ajax({
        url     : urlpaging,
        method  : 'GET',
        data    : { stdate:stdate, endate:endate, jnsdokbc:jnsdokbc, nodokbc:nodokbc, partno:partno, jumlahHalaman: jumlahHalaman },
        dataType: 'json',
        success : function(data)
        {
            var vallaquo = data.halamanAktif - 1;
            $("#loadingdata").remove();
            $('tbody').html(data.table_data);
            //  total count
            if(data.totalcount == 1)
            {
                $("#spn_totalcount").text("Total data "+data.totalcount+" record");
            }
            else if(data.totalcount > 1)
            {
                $("#spn_totalcount").text("Total data "+data.totalcount+" records");
            }
            else
            {
                $("#spn_totalcount").text("Data nothing");
            }
            //  pagination
            $("#navigation").remove();
            $("#writepagination").append(""
            + "<div id='navigation'>"
                + "<nav class='pagination-outer' aria-label='Page navigation'>"
                + "<ul class='pagination pagination-sm'>"
                    + "<li class='page-item '><a href='#' class='page-link' aria-label='First' onclick=\'first(1)\'><span aria-hidden='true'>First</span></a></li>"
                    + "<li class='page-item '><a href='#' class='page-link' aria-label='Previous' onclick=\'laquo("+(vallaquo)+")\'><span aria-hidden='true'>«</span></a></li>"
                    + "<li class='page-item disabled active'><a href='#' class='page-link' aria-label='First'><span aria-hidden='true'>"+data.halamanAktif+" of about "+data.jumlahHalaman+" page</span></a></li>"
                    + "<li class='page-item disabled'><a href='#' class='page-link' aria-label='Next'><span aria-hidden='true' class='text-muted'>»</span></a></li>"
                    + "<li class='page-item disabled'><a href='#' class='page-link' aria-label='Last'><span aria-hidden='true' class='text-muted'>Last</span></a></li>"
                + "</ul>"
                + "</nav>"
            + "</div>");
        }
    });
}

//  download data
function download(){
    var stdate      = $("#stdate").val().replace(/-/g, "");
    var endate      = $("#endate").val().replace(/-/g, "");
    var jnsdokbc    = $("#jnsdokbc").val();
    var nodokbc     = $("#nodokbc").val();
    var partno      = $("#partno").val();
    if (jnsdokbc === 'null') {
        jnsdokbc = null;
    }
    window.open("output/download?stdate="+stdate+"&endate="+endate+"&jnsdokbc="+jnsdokbc+"&nodokbc="+nodokbc+"&partno="+partno+"");
}

//  ***
//  start ajax
$(document).ready(function()
{
    //  buat tanggal
    var d       = new Date();
    // var stmonth   = d.getMonth();
    var enmonth   = d.getMonth()+1;
    var day     = d.getDate();
    var stdate  = d.getFullYear() + '-' +
                    ((''+enmonth).length<2 ? '0' : '') + enmonth + '-' +
                    '01';
    var endate  = d.getFullYear() + '-' +
                    ((''+enmonth).length<2 ? '0' : '') + enmonth + '-' +
                    ((''+day).length<2 ? '0' : '') + day;
    //  set value
    $("#stdate").val(stdate);
    $("#endate").val(endate);
    $("#jnsdokbc").val('');
    $("#nodokbc").val('');
    $("#partno").val('');

    //  load data
    // loaddata();

    //  trigger toogle
    $("#menuToggle").trigger('click');

    //  search data
    $('#endate').change(function (){ search(); });
    $("#jnsdokbc").keydown(function (e){ if(e.keyCode == 13){ search(); }});
    $("#nodokbc").keydown(function (e){ if(e.keyCode == 13){ search(); }});
    $("#partno").keydown(function (e){ if(e.keyCode == 13){ search(); }});
    $("#btn_cari").click(function(){ search(); });
    $("#btn_download").click(function(){ download(); });
    $("#btn_reset").click(function(){
        //  buat tanggal
        var d       = new Date();
        // var stmonth   = d.getMonth();
        var enmonth   = d.getMonth()+1;
        var day     = d.getDate();
        var stdate  = d.getFullYear() + '-' +
                        ((''+enmonth).length<2 ? '0' : '') + enmonth + '-' +
                        '01';
        var endate  = d.getFullYear() + '-' +
                        ((''+enmonth).length<2 ? '0' : '') + enmonth + '-' +
                        ((''+day).length<2 ? '0' : '') + day;
        //  set value
        $("#stdate").val(stdate);
        $("#endate").val(endate);
        $("#jnsdokbc").val('');
        $("#nodokbc").val('');
        $("#partno").val('');

        // loaddata();
        window.location.href =  window.location.href.split("#")[0];
    });
});
</script>
@endsection
