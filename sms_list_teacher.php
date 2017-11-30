<?php 
session_start();
$now = time();
if (isset($_SESSION['discard_after']) && $now > $_SESSION['discard_after']) {
    
    session_unset();
    session_destroy();
   
}

if(!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn']!=1){
    header('Location: index.php');
    exit();
}


include 'parameters.php';
$mysqli = new mysqli($servername, $username, $password , $dbname);
$mysqli->set_charset('utf8');


$sql = <<<SQL
    SELECT id , am , afm , FirstName , LastName , FatherFirstName ,  telephone , sxesi_ergasias
    FROM `teachers`
SQL;

if(!$result = $mysqli->query($sql)){
    die('There was an error running the query [' . $mysqli->error . ']');
}
?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />

   
    
   <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
   <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
   <script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
   <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.0/js/dataTables.responsive.min.js"></script>
   <script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
   <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.0/js/responsive.bootstrap.min.js"></script>
 <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.4.2/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/select/1.2.3/js/dataTables.select.min.js"></script>
     
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link type="text/css" href="https://cdn.datatables.net/buttons/1.4.2/css/buttons.dataTables.min.css" rel="stylesheet" /> 
    <link type="text/css" href="https://cdn.datatables.net/select/1.2.3/css/select.dataTables.min.css" rel="stylesheet" /> 
     <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css"/>
	<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.0/css/responsive.bootstrap.min.css"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

    <style type="text/css">
   
        th.dt-center, td.dt-center { text-align: center; }
        div.dt-buttons {
float: right;
margin-left:10px;
}

@media screen and (max-width: 600px) 
 {
    br 
    { 
       display: none;   // hide the BR tag for wider screens (i.e. disable the line break)
    }
 }

.glyphicon.spinning {
    animation: spin 1s infinite linear;
    -webkit-animation: spin2 1s infinite linear;
}

@keyframes spin {
    from { transform: scale(1) rotate(0deg); }
    to { transform: scale(1) rotate(360deg); }
}

@-webkit-keyframes spin2 {
    from { -webkit-transform: rotate(0deg); }
    to { -webkit-transform: rotate(360deg); }
}

    </style>



    <script type="text/javascript">
   
        $(document).ready(function() {
           $('#message').val('');
            $('#divform').hide();
            $('#togglebutton').hide();
            var maxChars = $("#message");
            var max_length = maxChars.attr('maxlength');
            if (max_length > 0) {
                maxChars.bind('keyup', function(e) {
                    length = new Number(maxChars.val().length);
                    counter = max_length - length;
                    $("#smsNum_counter").text(counter);
                });
            }


            $('#clear').on('click', function() {
                    $('#message').val('');
                    $("#smsNum_counter").text('140');
                }
            );

            var table = $('#teachers').DataTable({
              "dom": '<"#buttonDiv"B>lfrtip',
               responsive: true,
               rowId: 'id',
                buttons: [
                'selectAll',
                'selectNone' ],
               select: true,
              
              'columnDefs': [{
                        targets: [0 ],"visible": false,
                        "searchable": false
                    },{ "className": "dt-center", "targets": "_all" },
                ],
                'select': {
                    'style': 'multi'
                },
                'order': [
                    [3, 'asc']
                ] ,
                language:  {
    "sDecimal":           ",",
    "sEmptyTable":        "Δεν υπάρχουν δεδομένα στον πίνακα",
    "sInfo":              "Εμφανίζονται _START_ έως _END_ από _TOTAL_ εγγραφές",
    "sInfoEmpty":         "Εμφανίζονται 0 έως 0 από 0 εγγραφές",
    "sInfoFiltered":      "(φιλτραρισμένες από _MAX_ συνολικά εγγραφές)",
    "sInfoPostFix":       "",
    "sInfoThousands":     ".",
    "sLengthMenu":        "Δείξε _MENU_ εγγραφές",
    "sLoadingRecords":    "Φόρτωση...",
    "sProcessing":        "Επεξεργασία...",
    "sSearch":            "Αναζήτηση:",
    "sSearchPlaceholder": "Αναζήτηση",
    "sThousands":         ".",
    "sUrl":               "",
    "sZeroRecords":       "Δεν βρέθηκαν εγγραφές που να ταιριάζουν",
    "oPaginate": {
        "sFirst":    "Πρώτη",
        "sPrevious": "Προηγούμενη",
        "sNext":     "Επόμενη",
        "sLast":     "Τελευταία"
    },
    "oAria": {
        "sSortAscending":  ": ενεργοποιήστε για αύξουσα ταξινόμηση της στήλης",
        "sSortDescending": ": ενεργοποιήστε για φθίνουσα ταξινόμηση της στήλης"
    },
    'select': {
            'rows': "%d επιλεγμένες στύλες"
        }
} ,


initComplete: function () {
            
       
            this.api().columns([2,3,6,7]).every( function () {
                var column = this;
                var select = $('<select><option value=""></option></select>')
                    .appendTo( $(column.footer()).empty() )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
 
                        column
                            .search($(this).val())
                            .draw();
                    } );
 
                column.data().unique().sort().each( function ( d, j ) {
                    select.append( '<option value="'+d+'">'+d+'</option>' )
                } );
            } );
        }      
 });

        table.button(0).text('Επιλογή Όλων');  
        table.button(1).text('Αποεπιλογή Όλων');  

   table
        .on( 'select', function ( e, dt, type, indexes ) {
            var rows_selected = dt.rows( { selected: true } ).count();
            var rowData = table.rows( indexes ).data().toArray();
           
            $('#sms_names').text('');
            if ((rows_selected) >= 1) {
                $('#divform').show();

            } else {
                $('#divform').hide();
            }
            if ((rows_selected) > 4) {
               
                $('#togglebutton').show();
               
            } 
            else {
                $('#togglebutton').hide();
            }
         
            printSelectedRows();
          $('#sms_names').find('tr:gt(3)').toggle();
        
        
        
        } ) //.on()

        .on( 'deselect', function ( e, dt, type, indexes ) {

            var rows_selected = dt.rows( { selected: true } ).count();
            var rowData = table.rows( indexes ).data().toArray();
            $('#sms_names').text('');
            if ((rows_selected) >= 1) {
                $('#divform').show();

            } else {
                $('#divform').hide();
            }
           
          
            if ((rows_selected) <= 4) {
                $('#togglebutton').hide();

            } else {
                $('#togglebutton').show();
            }
            printSelectedRows();
            $('#sms_names').find('tr:gt(3)').toggle();
        } );
      
      
        $("#togglebutton").on("click", function() {
    $('#sms_names').find('tr:gt(3)').toggle();
    if($(this).text() == 'Απόκρυψη')
       {
           $(this).text('Εμφάνιση περισσότερων');
       }
       else
       {
           $(this).text('Απόκρυψη');
       }
           });
    
             
          
            $('#frm').on('submit', function(e) {
                e.preventDefault();
                
                var textareaData= $('#message').val();
                var rows_selected= table.rows( { selected: true } ).every( function ( rowIdx, tableLoop, rowLoop ) {
                var rowData = this.data();

                $( "#apostoli" ).addClass('disabled');
                $('#spanloading').addClass('glyphicon-refresh spinning');
                  $.ajax({
                dataType: "json",
                url: "smscenter.php",
                method: "POST",
                data: {to:rowData[6] , message:textareaData },
                cache: false,
                success:function(result){
                   var myselector="#smsno"+rowIdx;
                   var status = parseInt(result["status"]);
                   $("#sms_names").find(myselector).closest('tr').append('<td><b>Αναφορά:</b>'+ 
                              (status==1 ? 'Το μήνυμα στάλθηκε <img src="ok.png">': 'H αποστολή απέτυχε <img src="notok.png"></td>')).append('<td>Log from the mobile network: '+result["remarks"] + '</td>');
                 
                }
            }).done(function(results){
                    $.ajax({
                
                         url: "sms_log_insert_db.php",
                         method: "POST",
                         data: {Telephone1:rowData[6] , person:'2', name:rowData[4], surname:rowData[3] ,RegistrationNumber:rowData[2], message:textareaData , results:results},
                          cache: false,
                             success:function(result){
                                $('#spanloading').removeClass('glyphicon-refresh spinning');
                                $( "#apostoli" ).removeClass('disabled')   ;


                                                       }
                            });
                                         });
       });
    });

       
       
        function printSelectedRows() {
         
          var rows_selected= table.rows( { selected: true } ).every( function ( rowIdx, tableLoop, rowLoop ) {
          var rowData = this.data();
   
           $('#sms_names')   
        .append('<tr style="border: 1px solid black;"><td style=" border: 1px solid black;font-size: 85%;font-weight: bold; " id="smsno'+rowIdx+'">'+rowData[3] + ' ' + rowData[4] + ' ' + ' </td><td  style=" color: blue; border: 1px solid black;">'+rowData[6])
        .append('</td></tr>');
   
         });
             };
 });  //document ready

</script>
</head>

<body>
<?php
include 'navigation.php';
?><br>
<h3>
     Αποστολή SMS σε εκπαιδευτικούς 
 </h3>
 <br>
 <div style='border: 1px solid #000; display:inline-block ; background-color:yellow; word-wrap: break-word;'>
 <span style='background-color:yellow'><em>Οδηγίες:</em></span>
<strong> Επιλέγετε από τον πίνακα των εκπαιδευτικών κάνοντας click <span class='glyphicon glyphicon-hand-up'></span> 
πάνω στην αντίστοιχη γραμμή. <br>
Η γραμμή υπερτονίζεται με <span style='background-color:#B0BED9'>γκρι χρώμα</span> και τοποθετείται στη λίστα με τους επιλεγμένους παραλήπτες 
κάτω από τον πίνακα. <br>Μπορείτε να επιλέξετε το σύνολο των εγγραφών από το κουμπί "Επιλογή Όλων" και να 
αποστείλετε μαζικά <span class="fa-stack">
  <i class="fa fa-comment fa-stack-2x"></i>
  <i class="fa fa-stack-1x fa-stack-text fa-inverse">SMS </i>
</span> σε όλους</strong></div>

   <div id="buttonDiv"><br></div>
   <br>
<?php

echo "<table id='teachers' class='table table-striped table-bordered' width='100%' cellspacing='0'>
<thead>
<tr>
    <th>id</th>
    <th>ΑΜ</th>
    <th>ΑΦΜ</th>
     <th>Επίθετο</th>
     <th>Όνομα</th>
   
    <th>Πατρώνυμο</th>
   
    <th>Τηλέφωνο</th>
    <th>Σχέση Εργασίας</th> 
    </tr> </thead> <tfoot>
    <tr>
    <th>id</th>
    <th>ΑΜ</th>
    <th>ΑΦΜ</th>
     <th>Επίθετο</th>
     <th>Όνομα</th>
   
    <th>Πατρώνυμο</th>
   
    <th>Τηλέφωνο</th>
    <th>Σχέση Εργασίας</th> 
    </tr>
</tfoot><tbody>";



while($row = $result->fetch_assoc())
{
echo "<tr>";
echo "<td>" . $row['id'] . "</td>";
echo "<td>" . $row['am'] . "</td>";
echo "<td>" . $row['afm'] . "</td>";

echo "<td>" . $row['LastName'] . "</td>";
echo "<td>" . $row['FirstName'] . "</td>";
echo "<td>" . $row['FatherFirstName'] . "</td>";

echo "<td>" . $row['telephone'] . "</td>";
echo "<td>" . $row['sxesi_ergasias'] . "</td>";
echo "</tr>";
}
echo "</tbody></table>";
?>   
    <br>
    <br>
    <table style='table-layout: fixed; border-collapse: collapse; ' id="sms_names"></table>
    <br>
    <button id='togglebutton' class='btn btn-primary'>Εμφάνιση περισσότερων</button>
    <br><br>
    <div id="divform" style='margin-bottom:20px'>
        <form id="frm" action="#" method="GET">
            <textarea id="message" name="message" rows="4" cols="50" maxlength="140" required></textarea>
            <br>
            <br> Υπολοιπόμενοι Χαρακτήρες: <span id="smsNum_counter">140</span><br>
            <br>
            <button id="clear" type="reset" class='btn btn-danger'>Καθαρισμός</button>
            <button id="apostoli" class='btn btn-success' type="submit"> <span id="spanloading" class="glyphicon"></span> Αποστολή</button>
        </form>
    </div>

  
</body>
</html>