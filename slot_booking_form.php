<!DOCTYPE html>
<html>
<head>
    <title>Online Charging Station Slot Booking</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            animation: fadeIn 1s ease-in-out;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #666;
        }
        input[type="text"],
        input[type="email"],
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            transition: border-color 0.3s;
        }
        input[type="text"]:focus,
        input[type="email"]:focus,
        select:focus {
            border-color: #007bff;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <form action="./slot_booking_form.php" method="post">
        <h2>Book Your Charging Slot</h2>
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        
        <label for="slot">Select Time Slot:</label>
        <select id="slot" name="slot" required>
            <optgroup label="AM">
                <option value="12am-1am">12 AM - 1 AM</option>
                <option value="1am-2am">1 AM - 2 AM</option>
                <option value="2am-3am">2 AM - 3 AM</option>
                <option value="3am-4am">3 AM - 4 AM</option>
                <option value="4am-5am">4 AM - 5 AM</option>
                <option value="5am-6am">5 AM - 6 AM</option>
                <option value="6am-7am">6 AM - 7 AM</option>
                <option value="7am-8am">7 AM - 8 AM</option>
                <option value="8am-9am">8 AM - 9 AM</option>
                <option value="9am-10am">9 AM - 10 AM</option>
                <option value="10am-11am">10 AM - 11 AM</option>
                <option value="11am-12pm">11 AM - 12 PM</option>
            </optgroup>
            <optgroup label="PM">
                <option value="12pm-1pm">12 PM - 1 PM</option>
                <option value="1pm-2pm">1 PM - 2 PM</option>
                <option value="2pm-3pm">2 PM - 3 PM</option>
                <option value="3pm-4pm">3 PM - 4 PM</option>
                <option value="4pm-5pm">4 PM - 5 PM</option>
                <option value="5pm-6pm">5 PM - 6 PM</option>
                <option value="6pm-7pm">6 PM - 7 PM</option>
                <option value="7pm-8pm">7 PM - 8 PM</option>
                <option value="8pm-9pm">8 PM - 9 PM</option>
                <option value="9pm-10pm">9 PM - 10 PM</option>
                <option value="10pm-11pm">10 PM - 11 PM</option>
                <option value="11pm-12am">11 PM - 12 AM</option>
            </optgroup>
        </select>
        
        <input type="submit" value="Book Slot">
    </form>
</body>
</html>

<?php
    // Database connection parameters
    $servername = "localhost";
    $username = "root"; // Change this to your MySQL username
    $password = ""; // Change this to your MySQL password
    $dbname = "chargin"; // Ensure this is the correct database name

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Create table if it does not exist
    // $sql = "CREATE TABLE IF NOT EXISTS bookings (
    //     id INT AUTO_INCREMENT PRIMARY KEY,
    //     name VARCHAR(100) NOT NULL,
    //     email VARCHAR(100) NOT NULL,
    //     slot VARCHAR(20) NOT NULL,
    //     booking_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    // );";

    // if (!$conn->query($sql)) {
    //     die("Error creating table: " . $conn->error);
    // }

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get form data with validation
        $name = isset($_POST['name']) ? $_POST['name'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $slot = isset($_POST['slot']) ? $_POST['slot'] : '';

        
            // Check if slot is already booked
            $sql = "SELECT * FROM bookings WHERE slot = '$slot'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<p>Sorry, the selected time slot is already booked. Please choose a different slot.</p>";
            } else {
                // Insert booking data into the database
                $sql = "INSERT INTO bookings (name, email, slot) VALUES ('$name', '$email', '$slot')";

                if ($conn->query($sql) === TRUE) {
                    echo "<script>
                            alert('slot booked successfully');
                            window.location.href='Main_page.php';
                            </script>";
                } else {
                    echo "<p>Error: " . $sql . "<br>" . $conn->error . "</p>";
                }
        }
    }

    // Close the connection
    $conn->close();
    ?>