
@section('section_pdfSetting_dimmer')
    <div ng-show="section_pdfSetting_dimmer">
        <div   class="ui segment" style="position: absolute !important;
                                        top: 50%;
                                        left: 50%;
                                        min-height: 500px;
                                        width: 880px!important;
                                        border-top: 4px solid #12d7db;
                                        margin-left: -440px;
                                        margin-top: -400px;
                                        z-index: 20000;
">
            <h3 class="dimmer-title">@{{ FormTitle }}</h3>

            <!-- Notifications-->
            <div id="publicNotificationMessage" class="publicNotificationMessage" >
                <ul><li ng-repeat="er in errors" >@{{ er }} </li></ul>
            </div>

            <div class="main">
                <hr/>
                <!------ ------>
                <div class="row" style="text-align: right">
                    <div class="col-md-3 pull-right" style="padding-right: 50px;color: grey;">{{lang::get('labels.invoice_alias')}}</div>
                    <div class="col-md-2 pull-right" > <strong> @{{ invoiceIDs }} </strong></div>
                    <div class="col-md-7 pull-right"></div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-5 pull-right">
                        <div class="row">
                            <label class="containerx ng-binding">
                                <input type="checkbox" ng-click="setPDFStingAction('stng_customerName','boolean')" lass="checkboxz" value="25" ng-checked="name">
                                <span class="checkmark"></span>
                                {{lang::get('labels.invocePdfSting_lbl_showSellerName')}}
                            </label>
                        </div>
                        <div class="row">
                            <label class="containerx ng-binding">
                                <input type="checkbox" ng-click="setPDFStingAction('stng_changeDirection','boolean')" lass="checkboxz"   ng-checked="rtl == true">
                                <span class="checkmark"></span>
                                {{lang::get('labels.invocePdfSting_lbl_productTitleDirection')}}
                            </label>
                        </div>
                        <div class="row">
                            <label class="containerx ng-binding">
                                <input type="checkbox" ng-click="setPDFStingAction('stng_Price','boolean')" lass="checkboxz" value="25" ng-checked="Price == true">
                                <span class="checkmark"></span>
                                عدم نمایش قیمت
                            </label>
                        </div>
                        <div class="row">
                            <label class="containerx ng-binding">
                                <input type="checkbox" ng-click="setPDFStingAction('stng_UserAddress','boolean')" lass="checkboxz" value="25" ng-checked="UserAddress == true">
                                <span class="checkmark"></span>
                                عدم نمایش آدرس مشتری
                            </label>
                        </div>
                    </div>
                    <div class="col-md-5 pull-right">
                        <div class="row">
                            <div class="col-md-7 field_label pull-right">
                                {{lang::get('labels.invocePdfSting_lbl_mainTableFontSize')}}
                            </div>
                            <div class="col-md-3 pull-right">
                                <input   placeholder="12"   class="inputStyle" ng-model="stng_mainTableFontSize" type="number" ng-blur="allSettingSave('noClose')" >
                            </div>
                            <div class="col-md-2"> {{lang::get('labels.pixel')}} </div>
                        </div>
                        <div class="row">
                            <div class="col-md-7 field_label pull-right">
                                {{lang::get('labels.invocePdfSting_lbl_Desc_fontSize')}}
                            </div>
                            <div class="col-md-3 pull-right">
                                <input   placeholder="12"   class="inputStyle" ng-model="stng_Desc_fontSize" type="number" ng-blur="allSettingSave('noClose')">
                            </div>
                            <div class="col-md-2"> {{lang::get('labels.pixel')}}  </div>
                        </div>

                    </div>
                </div>
                <hr>
                <div class="col-md-12">
                    <div class="col-md-8 pull-right">
                        <div class="row">
                            <div class="col-md-7 field_label pull-right">
                                {{lang::get('labels.invocePdfSting_lbl_Dist_HeaderToContent')}}
                            </div>
                            <div class="col-md-3 pull-right">
                                <input   placeholder="30"     ng-click="setActive('stng_header_To_InvoiceBody')" class="inputStyle" ng-model="header_To_InvoiceBody" type="number" ng-blur="allSettingSave('noClose')" >
                            </div>
                            <div class="col-md-2">  </div>
                        </div>

                        <div class="row">
                            <div class="col-md-7 field_label pull-right">
                                {{lang::get('labels.invocePdfSting_lbl_Dist_Date_sellerInfo')}}
                            </div>
                            <div class="col-md-3 pull-right">
                                <input placeholder="{{lang::get('labels.default')}}" class="inputStyle"   ng-click="setActive('stng_date_To_sellerInfo')" ng-model="date_To_sellerInfo" type="number" ng-blur="allSettingSave('noClose')" >
                            </div>
                            <div class="col-md-2"> {{lang::get('labels.CM')}} </div>
                        </div>
                        <div class="row">
                            <div class="col-md-7 field_label pull-right">
                                {{lang::get('labels.invocePdfSting_lbl_Dist_seller_productTable')}}
                            </div>
                            <div class="col-md-3 pull-right">
                                <input placeholder="{{lang::get('labels.default')}}" class="inputStyle"    ng-click="setActive('stng_seller_To_InvoiceTable')" ng-model="seller_To_InvoiceTable" type="number" ng-blur="allSettingSave('noClose')">
                            </div>
                            <div class="col-md-2"> {{lang::get('labels.CM')}} </div>
                        </div>

                        <div class="row">
                            <div class="col-md-7 field_label pull-right">
                                {{lang::get('labels.invocePdfSting_lbl_Dist_productTable_desc')}}
                            </div>
                            <div class="col-md-3 pull-right">
                                <input placeholder="{{lang::get('labels.default')}}"      ng-click="setActive('stng_InvoiceTable_To_DescriptionTable')" class="inputStyle" ng-model="InvoiceTable_To_DescriptionTable" type="number" ng-blur="allSettingSave('noClose')" >
                            </div>
                            <div class="col-md-2"> {{lang::get('labels.CM')}} </div>
                        </div>
                    <hr>
                        <div class="row">
                            <div class="col-md-7 field_label pull-right"> {{lang::get('labels.invocePdfSting_lbl_signature_height_box')}}  </div>
                            <div class="col-md-3 pull-right">
                                <input ng-ifx="!showLabel_signature_Table_height"  placeholder="90"      ng-click="setActive('stng_signature_Table_height')" class="inputStyle" ng-model="signature_Table_height" type="number" ng-blur="allSettingSave('noClose')" >
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 pullright">
                        <img class="pdfPreview p_1" width="70%" src="/img/pdfPreview/1.jpg">
                        <img class="pdfPreview p_2" width="70%" src="/img/pdfPreview/2.jpg">
                        <img class="pdfPreview p_3" width="70%" src="/img/pdfPreview/3.jpg">
                        <img class="pdfPreview p_4" width="70%" src="/img/pdfPreview/4.jpg">
                        <img class="pdfPreview p_5" width="70%" src="/img/pdfPreview/5.jpg">
                    </div>
                </div>
                <div class="col-md-12">
                    <hr>
                    <div class="row" style="margin-top: 10px;">
                        <div class="col-md-4 pull-right"> </div>
                        <div class="col-md-2 pull-right">
                            {{--ng-click="allSettingSave('Close')"--}}
                            <div class="btn btn-success"  style="width: 100%;">{{lang::get('labels.save')}}</div>
                        </div>
                        <div class="col-md-2 pull-right">
                            <div class="btn btn-danger" ng-click="closepdfSetting()" style="width: 100%;">{{lang::get('labels.close')}}</div>
                        </div>
                    </div>
                </div>
                <!------ ------>
            </div>
        </div>
    </div>
@endsection
