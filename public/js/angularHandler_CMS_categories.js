

var app = angular.module('CMS_category_app', ['simplePagination']);
app.filter('html', function($sce) {
    return function(val) {
        return $sce.trustAsHtml(val);
    };
});


app.controller('CMS_category_Ctrl', ['$scope','$http','Pagination','$filter','$sce',
    function($scope, $http,Pagination,$filter,$sce )
    {

       function  OnInit() {
           get_category_list_by_Term_type();
           $scope.newCategory_InputBox=false;

           $scope.local    = $('#local').val();
           $scope.postType = $('#postType').val();
           $scope.term_id  = $('#term_id').val();
       }
       OnInit();
//----------------------------------------------
        function get_category_list_by_Term_type() {
            var Args={
                local: $('#local').val(),
                postType: $('#postType').val(),
                term_id: $('#term_id').val(),
            }

            routelink='/all-Categories-service/get_category_list_by_Term_type';
            $http.post(routelink,Args).then(
                function xSuccess(response)
                {
                    $scope.category_list_by_Term_type=response.data;
                    $scope.term_id=$scope.selectedCateory;

                    if (term_id==''){
                        $('#term_id').val(term_id=$scope.category_list_by_Term_type[0]['termID']);
                        term_id = $('#term_id').val();

                        $scope.selectedCateory=term_id.toString();
                    }
                    else{
                        term_id = $('#term_id').val();
                        $scope.selectedCateory=term_id.toString();
                    }


                    get_category_data(term_id);
                    get_all_SubCategory_List(term_id);

                }),
                function xError(response)
                {
                    console.log(response.data);
                }

        }
//----------------------------------------------
    $scope.catergorySelected=function () {
        $scope.term_id=$scope.selectedCateory;
        $('#term_id').val($scope.selectedCateory);
        // alert($('#term_id').val());
        window.location.href = "/all-Categories/"+$('#local').val()+"/"+$('#postType').val()+"/"+$('#term_id').val();
        // get_category_data($('#term_id').val());
        // get_all_SubCategory_List($('#term_id').val())
    }
//----------------------------------------------

        function  get_category_data(termID){
            $scope.Tdata=termID;
            var Args={
                local: $('#local').val(),
                postType: $('#postType').val(),
                termId: termID
            }
            console.log(Args)
             routelink='/all-Categories-service/showAllCategory_data';
            $http.post(routelink,Args).then(
                function xSuccess(response)
                {
                    $scope.$watch($sce.trustAsHtml(response.data[0]), function() {
                        $scope.catList=$sce.trustAsHtml(response.data[0]);
                        $scope.$apply();
                    });
                   //  $scope.catList=$sce.trustAsHtml(response.data[0])
                    // setTimeout(function(){ }, 1000);


                }),
                function xError(response)
                {
                    console.log(response.data);
                }
        }
//----------------------------------------------
        function  get_all_SubCategory_List(termId){

            //
            var Args={
                local: $('#local').val(),
                postType: $('#postType').val(),
                term_id: termId
            }

             routelink='/all-Categories-service/category_list';
            $http.post(routelink,Args).then(
                function xSuccess(response)
                {
                   // $scope.selectCatList=$sce.trustAsHtml(response.data);
                    $scope.selectCatList=$sce.trustAsHtml(response.data[1]['list']);
                    console.log(response.data[1]['list']);
                    $scope.public_termID=termId;
                }),
                function xError(response)
                {
                    console.log(response.data);
                }
        }
//----------------------------------------------

    $scope.saveNewCategory =function () {
        if ($('#term_id').val())
            TermId= $('#term_id').val();
        else
            TermId=$scope.term_id;

            var  Args={
                termID:TermId,
                newCatName:   $scope.newCatName,
                newCatSlug: $scope.newCatSlug,
                newCatParent: $('#newCatParent').val()
            }
        routelink='/all-Categories-service/addNewCategory';
        $http.post(routelink,Args).then(
            function xSuccess(response)
            {
                if (response.data){
                    get_category_data(TermId);
                    get_all_SubCategory_List(TermId);
                }
            }),
            function xError(response)
            {
                console.log(response.data);
            }

    }
//----------------------------------------------
    $scope.show_newCategory_InputBox=function () {
        $scope.newCategory_InputBox=true;
    }
//----------------------------------------------
    $scope.hide_newCategory_InputBox=function () {
        $scope.newCategory_InputBox=false;
    }
//----------------------------------------------
    $scope.add_new_wCategory_Item=function () {
        var  Args={
            local: $('#local').val(),
            postType: $('#postType').val(),
            newCategoryName: $scope.newCategoryName
        }

        routelink='/all-Categories-service/add_new_wCategory_Item';
        $http.post(routelink,Args).then(
            function xSuccess(response)
            {
                newTermId=response.data;
                window.location.href = "/all-Categories/"+$('#local').val()+"/"+$('#postType').val()+"/"+newTermId;
            }),
            function xError(response)
            {
                console.log(response.data);
            }

    }
//----------------------------------------------

    }]);
