<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/> 
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script> 
</head>
<body class="container" >
    

<?php 
include'db_connect.php';
session_start();
$fetch_event = $conn->query("SELECT * FROM appointment");
?>

<div class="col-lg-12">
	<div class="card card-outline card-info">
		<div class="card-body">
  <h2><center>Calendar</center></h2>
  <div class="container">
   <div id="calendar"></div>
  </div>
  <br>
  </div>
    </div>
	
  <script>
    $(document).ready(function(){
        $('#calendar').fullCalendar({
            header:
            {
                left: 'month, agendaWeek',
                center: 'title'
            },

            events:[
            <?php 
            while($result = mysqli_fetch_array($fetch_event))
            
                {?>
            {
                
                id: '<?php echo $result['Appointment_id'];?>',
                title: '<?php echo $result['Patient_name'];?>',
                start: '<?php echo $result['Appointment_date'];?>',
                time: '<?php echo $result['Appointment_time'];?>',
                color: 'yellow',
                textColor: 'black'
                

            },
          <?php } ?>
            ],
            editable: true,
            eventDrop: function(event)
            {
                var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
                var time = event.time;
                var Patient_name = event.Patient_name;
                var id = event.id;
                $.ajax({
                    url: "update.php",
                    type: "POST",
                    data: {Patient_name: Patient_name, start: start, time: time, id:id},
                    success: function()
                    {
                        alert("Event Updated Successfully");
                    }
                });
            }
        });
    });
</script>
</body>
</html>

//Refference:Adapted from Codetester.Available at:https://www.youtube.com/watch?v=Fru-BzAr-LE