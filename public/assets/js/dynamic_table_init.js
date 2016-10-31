function fnFormatDetails( oTable, nTr ){
    var aData = oTable.fnGetData( nTr );
    var sOut = '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">';
	//sOut += '<tr><td>images avatar</td><td rowspan="3">image</td></tr>';
    sOut += '<tr><td><a href="?type=register&action=editWallet&!id/'+aData[1]+'" class="btn btn-sm btn-danger">Edit Wallet</a> &nbsp; <a href="?type=register&action=deleteWallet&!id/'+aData[1]+'" class="btn btn-sm btn-danger">Delete Wallet</a></td></tr>';
    sOut += '</table>';

    return sOut;
}

function fnFormatLevels(oTable, nTr){
    var aData = oTable.fnGetData( nTr );
    var sOut = '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">';
	//sOut += '<tr><td>images avatar</td><td rowspan="3">image</td></tr>';
    sOut += '<tr><td><a href="?type=register&action=editWallet&id='+aData[1]+'" class="btn btn-sm btn-danger">Edit Wallet</a> &nbsp; <a href="?type=register&action=deleteWallet&id='+aData[1]+'" class="btn btn-sm btn-danger">Delete Wallet</a></td></tr>';
   
    sOut += '</table>';

    return sOut;
}


$(document).ready(function() {
    $('#dynamic-table').dataTable( {
        "aaSorting": [[ 1, "asc" ]],
        "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
    });
    
    var tableCourse = $('#dynamic-table-example').DataTable({
        "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        "processing": true,
        "serverSide": true,
        "ajax"      : {
            url: "http://localhost/examiner/course/tableFlow",
            method: "POST"
        },
        columnDefs: [{
            "targets": -1,
            "data": null,
            "defaultContent": "<button class='btn btn-default btn-sm edit_btn'><strong>Edit</strong></button> <button class='btn btn-danger btn-sm'><strong>Delete</strong></button>"
        }],
        columns: [
            {data: "title"},
            {data: "code"},
            {data: "session"},
            {data: "department"},
            {data: null},
        ]
    });
    
    var tableAction = $('#dynamic-table-course').DataTable({
        "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        "processing": true,
        "serverSide": true,
        "ajax"      : {
            url: "http://localhost/examiner/course/tableFlow",
            method: "POST"
        },
        columnDefs: [{
                "targets": -1,
                "data": null,
                "defaultContent": "<select class='form-control select_vars' style='font-size:12px'><option>Please wait ...</option></select>"
            },
            {
                "targets": 4,
                "data": null,
                "defaultContent": ""
            },
        ],
        columns: [
            {data: "title"},
            {data: "code"},
            {data: "session"},
            {data: "department"},
            {data: "lecturer"},
            {data: null}
        ],
        drawCallback: function(){
            var api = this.api(), options = '';
            $.get('http://localhost/examiner/lecturer/getLecturer', function(data){
                var jsonFlow = $.parseJSON(JSON.stringify(data));
                for(var i = 0; i < jsonFlow.data.length; i++){
                    //getLecturer[i] = jsonFlow.data[i];
                    options += '<option value="'+jsonFlow.data[i].codename+'">'+jsonFlow.data[i].fullname.toUpperCase()+'</option>';
                }
                //alert(options) this can break and load
                //But instead put the api callback in the ajax function callback;
                api.$('select').each(function(i){
                    var optionVar = $(options)
                            .appendTo($(this).empty()).on('change', function(){
                                var val = $(this).val();
                    })
                })
            })
        }
    });
    
    //Assign lecturer to the courses offered in the school
    $("#dynamic-table-course tbody").on( 'change', 'select', function (){
        var selVar = $(this).val(), actThis = $(this);
        var data = tableAction.row($(this).parents('tr')).data();
        //alert(data['code']+'/'+selVar);
        $.post('http://localhost/examiner/lecturer/setAssign',{code:data['code'],codename:selVar}, function(data){
            var returnJson = $.parseJSON(JSON.stringify(data));
            if(returnJson.status == 'OK'){
                actThis.parents('tr').children('td').eq(4).
                        text(returnJson.data.firstname+' '+returnJson.data.lastname);
            }
            else{
                bootbox.alert('returnJson.message +'+returnJson.message[0]);
            }
        })
    })
    
    /**
     * Edit | Delete courses & Display all courses
     * DataTable makes life easy here for me
     */
    var tablePackage = $('#dynamic-table-package').DataTable({
        "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        "processing": true,
        "serverSide": true,
        "ajax"      : {
            url: "http://localhost/examiner/packages/editPackages",
            method: "POST"
        },
        columnDefs: [{
            "targets": -1,
            "data": null,
            "defaultContent": "<button class='btn btn-default btn-sm edit_btn'><strong>Edit</strong></button> <button class='btn btn-danger btn-sm'><strong>Delete</strong></button>"
        }],
        columns: [
            {data: "title"},
            {data: "code"},
            {data: "session"},
            {data: "department"},
            {data: "semester"},
            {data: "lecturer"},
            {data: null},
        ]
    });
    
    //Edit table course on clicking the edit button
    $('#dynamic-table-example tbody').on('click','.edit_btn', function(){
        var tableRowResult = tableCourse.row($(this).parents('tr')).data();
        var courseRowId = tableRowResult['c_id'];
       $.post('http://localhost/examiner/course/edit', {c_id: courseRowId}, function(data){
           var JsonString = $.parseJSON(JSON.stringify(data));
           if(JsonString.status == 'OK'){
               var formString = '<h4><strong>'+JsonString.data['title']+'</strong>';
                formString  += '</h4><form id="formEdit" method="post">';
                for(var i in JsonString.data){
                    formString += '<div class="form-group"><input class="form-control" value="'+JsonString.data[i]+'" />';
                    formString += '<p><strong>'+i+'</strong></p></div>';
                }
                formString += '</form>';
                bootbox.confirm(formString, function(results){
                    
                })
           }
       });
    });
    
    $('#dynamic-table-course tbody').on('click','.select_vars', function(){
        
    })
    
    //Edit method for posting and editing packaged courses
    $('#dynamic-table-package tbody').on('click','.edit_btn', function(){
        var tableRowResult = tablePackage.row($(this).parents('tr')).data();
        var packageRowId = tableRowResult['package_id'];
        $.post('http://localhost/examiner/packages/edit', {package_id: packageRowId}, function(data){
            var JsonString = $.parseJSON(JSON.stringify(data));
            if(JsonString.status == 'OK'){
                var formString = '<h4><strong>'+JsonString.data['title']+'</strong>';
                formString  += '</h4><form id="formEdit" method="post">';
                for(var i in JsonString.data){
                    formString += '<div class="form-group"><input class="form-control" value="'+JsonString.data[i]+'" />';
                    formString += '<p><strong>'+i+'</strong></p></div>';
                }
                formString += '</form>';
                bootbox.confirm(formString, function(result){
                    var formObject = $('#formEdit').serialize();
                    if(result){
                        $.post('http://localhost/examiner/packages/editPost', formObject, function(data){
                            var jsonArray = $.parseJSON(JSON.stringify(data));
                            bootbox.alert(jsonArray.status);
                        })
                    }
                })
            }
        })
    });
    
    /**
     * Delete the pacakaged course using the package_id
     */
    $('#dynamic-table-package tbody').on('click','.delete_btn', function(){
        var tableRowResult = tablePackage.row($(this).parents('tr')).data();
        var packageRowId = tableRowResult['package_id'];
        $.post('http://localhost/examiner/packages/delete', {package_id: packageRowId}, function(data){
            var JsonString = $.parseJSON(JSON.stringify(data));
        })
    });
});

//Creating a new ready document
/* Formatting function for row details - modify as you need */
function format ( d ) {
    // `d` is the original data object for the row
    return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
        '<tr>'+
            '<td><input type="text" class="form-control session_ctrl" placeholder="Enter Session(2015/2016)" /></td>'+
            '<td><select class="form-control semester_ctrl"><option value="1">1</option><option value="2">2</option></select></td>'+
            '<td><button class="btn btn-default btn-sm register" style="font-weight:bold">100</button> <button class="btn btn-default btn-sm register" style="font-weight:bold">200</button> <button class="btn btn-default btn-sm register" style="font-weight:bold">300</button> <button class="btn btn-default btn-sm register" style="font-weight:bold">400</button></td>'+
            '<td><button class="btn btn-primary btn-sm department_ctrl"><strong>'+d.department+'</strong></button></td>'+
            '<td><button class="btn btn-primary btn-sm matric_ctrl"><strong>'+d.matric+'</strong></button></td>'
        '</tr>'+
    '</table>';
}
 
$(document).ready(function() {
    //Display students registered
    var table = $('#student-datatable').DataTable( {
        "processing": true,
        "serverSide": true,
        "ajax"      : {
            url: "http://localhost/examlecturer/students/getStudents",
            method: "POST"
        },
        "columns": [
            { "data": "creg_id" },
            { "data": "firstname" },
            { "data": "title" },
            { "data": "course" },
            { "data": "matric" },
            { "data": "level" },
            { "data": "department" },
            { "data": "session" },
            //{ "data": "creg_id" },
            { "data": null },
        ],
        columnDefs: [{
            "targets": -1,
            "data": null,
            //"defaultContent": "<button class='btn btn-default btn-sm block_btn'><strong>Block</strong></button> <button class='btn btn-danger btn-sm'><strong>Delete</strong></button>"
            "defaultContent": "<input type='text' name='ca[]' placeholder='CA' required class='form-control' size=3 maxlength=2 /> <input type='text' name='exam[]' placeholder='Exam' required class='form-control' size=3 maxlength=2 />"
        },{
            "render" : function(data, type, row){
                return data.toUpperCase();
            },
            "targets": 3,
        }],
        "order": [[1, 'desc']]
    } );
     
    // Get all the rows value in the datatable show
    $('#student-datatable tfoot').on('click', '#resultsubmit', function () {
        var stackFlow = [];
        
        //This is easiest way of getting the row datas at once
        var tableData = table.rows().data();
        
        //This gets the input values serialized for use
        var tableInputs = table.$('input[type=text]').serialize();
        
        //Use instead of the tableData issues of insertHTML
        table.rows().eq(0).each(function(index){
            var row = table.row(index);
            var data = row.data();
            stackFlow.push(data);
        })
        
        $.post('http://localhost/examlecturer/results/httpResult',
        {stacks: stackFlow, serial: tableInputs}, function(data){
            var JSONStringify = $.parseJSON(JSON.stringify(data));
            if(JSONStringify.status == 'OK'){
                bootbox.alert('<strong>Result Uploaded Successfully</strong>');
            }
            else{
                bootbox.alert('<strong>There is Problem. Contact your Administrator</strong>');
            }
        });
        
        /**table.rows().every(function(rowIdx, tableLoop, rowLoop){
            var data = this.data();
            alert(data);
        })**/
    });
    
    //Add event listener for registration
    //Actually this should be the last resort students are to register themselves
    $('#student-datatable tbody').on('click', 'button.register', function () {
        var btnLevel = $(this).text();
        //var data = api.column( 5 ).data();
        var txtSession = $(this).closest('tr').find('input[type=text]');
        var selectSemester = $(this).closest('tr').find('.semester_ctrl option:selected');
        var department = $(this).closest('tr').find('.department_ctrl');
        var matricNumber = $(this).closest('tr').find('.matric_ctrl');
        //alert(JSON.stringify(department.text()));
        $.post('http://localhost/examiner/courseregistration/getPackage',
        {'level':btnLevel, 'session':txtSession.val(), 'semester':selectSemester.val(),
            'department':department.text(),'matric':matricNumber.text()}, function(data){
            var stringJson = $.parseJSON(JSON.stringify(data));
            if(stringJson.status == 'OK'){
                bootbox.alert('Registration for '+stringJson.data.firstname
                        +'/'+stringJson.data.level+' Done');
            }
        })
    });
} );