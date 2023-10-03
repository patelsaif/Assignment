<?php

$curl = curl_init();

$currentDate = date('Y-m-d');

curl_setopt_array($curl, array(
  CURLOPT_URL => "http://localhost/Assignment/api.php?date={$currentDate}",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
));

$response = curl_exec($curl);

if ($response === false) {
    die('Curl error: ' . curl_error($curl));
}

curl_close($curl);

$dataArray = json_decode($response, true);

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>Calendar</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">
</head>

<body>
    <div class="maindiv">
        <div class="calendar-container">
            <header class="calendar-header">
                <p class="calendar-current-date"></p>
                <div class="calendar-navigation">
                    <span id="calendar-prev" class="material-symbols-rounded">chevron_left</span>
                    <span id="calendar-next" class="material-symbols-rounded">chevron_right</span>
                </div>
            </header>
            <div class="calendar-body">
                <ul class="calendar-weekdays">
                    <li>Sun</li>
                    <li>Mon</li>
                    <li>Tue</li>
                    <li>Wed</li>
                    <li>Thu</li>
                    <li>Fri</li>
                    <li>Sat</li>
                </ul>
                <ul class="calendar-dates"></ul>
            </div>
        </div>
        <div class="main-content">
            <?php

foreach ($dataArray as $item) {
    $value1 = $item['cdata'];
    $value2 = $item['additionalInfo'];
    $value3 = $item['cimage'];

    echo "<div class='box-shadow'>
                <img src='http://localhost/Assignment/$value3' alt=''>
                <h3>$value1</h3>
                <p>$value2</p>
        </div>";
}
foreach ($dataArray as $item) {
    $value1 = $item['cdata'];
    $value2 = $item['additionalInfo'];
    $value3 = $item['cimage'];

    echo "<div class='box-shadow'>
                <img src='http://localhost/Assignment/$value3' alt=''>
                <h3>$value1</h3>
                <p>$value2</p>
        </div>";
}
            ?>
    </div>
    
    <style>
        .box-shadow {
            min-width: 30%;
            border: 2px solid #414141;
            padding: 10px;
            margin: 5px;
        }
        .maindiv{
            display: flex;
            flex-direction: row;
        }
        .main-content {
            width: 80%;
            display: flex;
        }
        img {
            width: 100%;
        }
        * {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            height: 100vh;
        }
        
        .calendar-container {
            background: #fff;
            width: 20%;
            height: 100%;
            border-radius: 10px;
            border: 2px solid #414141;
        }
        
        .calendar-container header {
            display: flex;
            align-items: center;
            padding: 15px 20px 0px;
            justify-content: space-between;
        }
        
        header .calendar-navigation {
            display: flex;
        }
        
        header .calendar-navigation span {
            height: 38px;
            width: 38px;
            margin: 0 1px;
            cursor: pointer;
            text-align: center;
            line-height: 38px;
            border-radius: 50%;
            user-select: none;
            color: #aeabab;
            font-size: 1.00rem;
        }
        
        .calendar-navigation span:last-child {
            margin-right: -10px;
        }
        
        header .calendar-navigation span:hover {
            background: #f2f2f2;
        }
        
        header .calendar-current-date {
            font-weight: 500;
            font-size: 0.90rem;
        }
        
        .calendar-body {
            padding: 5px;
        }
        
        .calendar-body ul {
            list-style: none;
            flex-wrap: wrap;
            display: flex;
            text-align: center;
        }
        
        .calendar-body .calendar-dates {
            margin-bottom: 20px;
        }
        
        .calendar-body li {
            width: calc(100% / 7);
            font-size: 0.65rem;
            color: #414141;
        }
        
        .calendar-body .calendar-weekdays li {
            cursor: default;
            font-weight: 500;
        }
        
        .calendar-body .calendar-dates li {
            margin-top: 20px;
            position: relative;
            z-index: 1;
            cursor: pointer;
        }
        
        .calendar-dates li.inactive {
            color: #aaa;
        }
        
        .calendar-dates li.active {
            color: #fff;
        }
        
        .calendar-dates li::before {
            position: absolute;
            content: "";
            z-index: -1;
            top: 50%;
            left: 50%;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            transform: translate(-50%, -50%);
        }
        
        .calendar-dates li.active::before {
            background: #6332c5;
        }
        
        .calendar-dates li:not(.active):hover::before {
            background: #e4e1e1;
        }
    </style>
    <script>
        let date=new Date(); // creates a new date object with the current date and time
        let year=date.getFullYear(); // gets the current year
        let month=date.getMonth(); // gets the current month (index based, 0-11)
        
        const day=document.querySelector(".calendar-dates"); // selects the element with class "calendar-dates"
        const currdate=document.querySelector(".calendar-current-date"); // selects the element with class "calendar-current-date"
        const prenexIcons=document.querySelectorAll(".calendar-navigation span"); // selects all elements with class "calendar-navigation span"
        
        const months=[
        "January",
        "February",
        "March",
        "April",
        "May",
        "June",
        "July",
        "August",
        "September",
        "October",
        "November",
        "December"]; // array of month names
        
        // function to generate the calendar
        const manipulate=()=> {
            // get the first day of the month
            let dayone=new Date(year, month, 1).getDay();
        
            // get the last date of the month
            let lastdate=new Date(year, month + 1, 0).getDate();
        
            // get the day of the last date of the month
            let dayend=new Date(year, month, lastdate).getDay();
        
            // get the last date of the previous month
            let monthlastdate=new Date(year, month, 0).getDate();
        
            let lit=""; // variable to store the generated calendar HTML
        
            // loop to add the last dates of the previous month
            for (let i=dayone; i > 0; i--) {
        lit+=`<li class="inactive">${monthlastdate - i + 1}</li>`;
            }
        
            // loop to add the dates of the current month
            for (let i=1; i <=lastdate; i++) {
        // check if the current date is today
        let isToday=i===date.getDate() && month===new Date().getMonth() && year===new Date().getFullYear() ? "active": "";
        lit+=`<li class="${isToday}">${i}</li>`;
            }
        
            // loop to add the first dates of the next month
            for (let i=dayend; i < 6; i++) {
        lit+=`<li class="inactive">${i - dayend + 1}</li>`
            }
        
            // update the text of the current date element with the formatted current month and year
            currdate.innerText=`${months[month]} ${year}`;
        
            // update the HTML of the dates element with the generated calendar
            day.innerHTML=lit;
        }
        
        manipulate();
        
        // Attach a click event listener to each icon
        prenexIcons.forEach(icon=> {
        
        // When an icon is clicked
        icon.addEventListener("click", ()=> {
                // Check if the icon is "calendar-prev" or "calendar-next"
                month=icon.id==="calendar-prev" ? month - 1 : month + 1;
        
                // Check if the month is out of range
                if (month < 0 || month > 11) {
                    // Set the date to the first day of the month with the new year
                    date=new Date(year, month, new Date().getDate());
                    // Set the year to the new year
                    year=date.getFullYear();
                    // Set the month to the new month
                    month=date.getMonth();
                }
       
                // Call the manipulate function to update the calendar display
                manipulate();
            });
            });

    </script>
    <script>
        let some = document.querySelectorAll('.calendar-dates li')
        some.forEach(day=>{
            day.addEventListener("click", ()=> {
            console.log(day.innerHTML)
            // APi call https//:www.saif.com/getdata/day=day.innerHTML
            // create datebase
            //How to write an API with databse
            //Create an API with Title, Description, Image
            // Define the URL of your PHP API
            const apiUrl = 'http://localhost/Assignment/api.php';

            // Make a GET request to the API
            fetch(apiUrl)
            .then(response => {
                // Check if the response status is OK (status code 200)
                if (!response.ok) {
                throw new Error('Network response was not ok');
                }
                // Parse the JSON response
                return response.json();
            })
            .then(data => {
                // Handle the data here
                console.log(data); // This will log the data to the browser's console
            })
            .catch(error => {
                // Handle errors here
                console.error('Fetch error:', error);
            });

            
            //API which take 'Date' as input and gives Title, Description, Image according date
            // data lagana
        }
        )
        })

        // Loadmore remining
        
    </script>
</body>
</html>