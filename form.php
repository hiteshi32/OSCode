<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";  // Default XAMPP password is empty
$dbname = "school_admission";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST["student-name"];
    $dob = $_POST["dob"];
    $gender = $_POST["gender"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];
    
    // Handle file upload
    if (isset($_FILES["uploads"]) && $_FILES["uploads"]["error"] == 0) {
        $uploads = $_FILES["uploads"];
        $uploadDir = "uploads/";
        $uploadFilePath = $uploadDir . basename($uploads["name"]);
        
        // Move the uploaded file to the 'uploads' directory
        if (move_uploaded_file($uploads["tmp_name"], $uploadFilePath)) {
            $filePath = $uploadFilePath; // Save the file path to the database
        } else {
            echo "Error: Failed to upload the file.";
            exit;
        }
    } else {
        $filePath = null;  // If no file is uploaded
    }

    // Prepare the query to insert the form data
    $stmt = $conn->prepare("INSERT INTO student (full_name, dob, gender, phone, address, uploads) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $full_name, $dob, $gender, $phone, $address, $filePath);
    
    if ($stmt->execute()) {
        echo "<script>alert('Admission Form Submitted Successfully!');</script>";
    } else {
        echo "Error: " . $stmt->error;
    }
    
    $stmt->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Admission</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: url('girl.webp') center/cover fixed;
            padding: 20px;
        }

        .modal {
            background: rgba(255, 255, 255, 0.95);
            padding: 30px;
            border-radius: 15px;
            width: 100%;
            max-width: 500px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            position: relative;
        }

        .modal-close {
            position: absolute;
            top: 15px;
            right: 20px;
            cursor: pointer;
            font-size: 24px;
            color: #666;
            transition: color 0.3s;
        }

        .modal-close:hover {
            color: #333;
        }

        .modal-content {
            padding: 10px;
        }

        h2 {
            color: rgb(32, 110, 158);
            margin-bottom: 25px;
            font-size: 28px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #444;
            font-weight: 500;
        }

        input, select, textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s, box-shadow 0.3s;
            background: white;
        }

        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: rgb(32, 110, 158);
            box-shadow: 0 0 0 3px rgba(32, 110, 158, 0.1);
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        button {
            width: 100%;
            padding: 14px;
            background-color: rgb(32, 110, 158);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.1s;
        }

        button:hover {
            background-color: rgb(25, 85, 124);
        }

        button:active {
            transform: scale(0.98);
        }

        @media (max-width: 600px) {
            .modal {
                margin: 10px;
                padding: 20px;
            }

            h2 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="modal">
        <div class="modal-close" onclick="window.location.href='index.html'">&times;</div>
        <div class="modal-content">
            <h2>School Admission Form</h2>
            <form method="POST" action="" enctype="multipart/form-data">
            <div class="form-group">
                    <label for="student-name">Student's Full Name</label>
                    <input type="text" id="student-name" name="student-name" required>
                </div>

                <div class="form-group">
                    <label for="dob">Date of Birth</label>
                    <input type="date" id="dob" name="dob" required>
                </div>

                <div class="form-group">
                    <label for="gender">Gender</label>
                    <select id="gender" name="gender" required>
                        <option value="">Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="phone">Parent/Guardian Phone Number</label>
                    <input type="tel" id="phone" name="phone" required>
                </div>

                <div class="form-group">
                    <label for="address">Address</label>
                    <textarea id="address" name="address" required></textarea>
                </div>
                
                <div class="form-group">
                <label for="birth_certificate">Upload Documents</label>
                <h>Upload copy of adhaar card and birth-certificate</h>
                <input type="file" id="birth_certificate" name="uploads">
                </div>

                <button type="submit">Submit Application</button>
            </form>
        </div>
    </div>
<!-- Code injected by live-server -->
<script>
	// <![CDATA[  <-- For SVG support
	if ('WebSocket' in window) {
		(function () {
			function refreshCSS() {
				var sheets = [].slice.call(document.getElementsByTagName("link"));
				var head = document.getElementsByTagName("head")[0];
				for (var i = 0; i < sheets.length; ++i) {
					var elem = sheets[i];
					var parent = elem.parentElement || head;
					parent.removeChild(elem);
					var rel = elem.rel;
					if (elem.href && typeof rel != "string" || rel.length == 0 || rel.toLowerCase() == "stylesheet") {
						var url = elem.href.replace(/(&|\?)_cacheOverride=\d+/, '');
						elem.href = url + (url.indexOf('?') >= 0 ? '&' : '?') + '_cacheOverride=' + (new Date().valueOf());
					}
					parent.appendChild(elem);
				}
			}
			var protocol = window.location.protocol === 'http:' ? 'ws://' : 'wss://';
			var address = protocol + window.location.host + window.location.pathname + '/ws';
			var socket = new WebSocket(address);
			socket.onmessage = function (msg) {
				if (msg.data == 'reload') window.location.reload();
				else if (msg.data == 'refreshcss') refreshCSS();
			};
			if (sessionStorage && !sessionStorage.getItem('IsThisFirstTime_Log_From_LiveServer')) {
				console.log('Live reload enabled.');
				sessionStorage.setItem('IsThisFirstTime_Log_From_LiveServer', true);
			}
		})();
	}
	else {
		console.error('Upgrade your browser. This Browser is NOT supported WebSocket for Live-Reloading.');
	}
	// ]]>
</script>
</body>
</html>