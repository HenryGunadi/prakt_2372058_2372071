<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .custom-dropdown {
            position: relative;
            display: inline-block;
        }

        .custom-dropdown-button {
            background-color: #6c757d;
            color: white;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .custom-dropdown-button:hover {
            background-color: #5a6268;
        }

        .custom-dropdown-menu {
            display: none;
            position: absolute;
            background-color: white;
            min-width: 160px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            overflow: hidden;
            z-index: 1000;
            opacity: 0;
            transform: translateY(-10px);
            transition: opacity 0.3s ease, transform 0.3s ease;
        }

        .custom-dropdown-menu a {
            display: block;
            padding: 10px;
            color: black;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .custom-dropdown-menu a:hover {
            background-color: #f1f1f1;
        }

        .custom-dropdown.show .custom-dropdown-menu {
            display: block;
            opacity: 1;
            transform: translateY(0);
        }

        .dropdown-icon {
            width: 24px;
            height: 24px;
            transition: transform 0.3s ease;
        }

        .custom-dropdown.show .dropdown-icon {
            transform: rotate(180deg);
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <div class="custom-dropdown">
        <button class="custom-dropdown-button" onclick="toggleDropdown()">
            Dropdown link
            <img src="{{ asset('asset/img/svg/chevron-down.svg')}}" alt="" class="dropdown-icon">
        </button>
        <div class="custom-dropdown-menu" id="dropdownMenu">
            <a href="#">Action</a>
            <a href="#">Another action</a>
            <a href="#">Something else here</a>
        </div>
    </div>

    <script>
        function toggleDropdown() {
            const dropdown = document.querySelector(".custom-dropdown");
            dropdown.classList.toggle("show");
        }

        // Close the dropdown when clicking outside
        document.addEventListener("click", function(event) {
            const dropdown = document.querySelector(".custom-dropdown");
            if (!dropdown.contains(event.target)) {
                dropdown.classList.remove("show");
            }
        });
    </script>
</body>
</html>
