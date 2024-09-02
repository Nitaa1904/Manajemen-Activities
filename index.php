<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Today's Activities</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #1A1A2E;
            background-image: linear-gradient(to bottom, #1A1A2E, #16213E);
            height: 100vh;
            margin: 0;
        }
        .container {
            max-width: 500px;
            margin: 40px auto;
            padding: 20px;
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            animation: fadeIn 1s;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .todo-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .todo-list li {
            padding: 10px;
            border-bottom: 1px solid #ccc;
            transition: background-color 0.5s;
        }
        .todo-list li:last-child {
            border-bottom: none;
        }
        .todo-list li:hover {
            background-color: #E1F7F5;
        }
        .checkbox {
            margin-right: 10px;
        }
        .hapus {
            float: right;
            color: #337ab7;
            text-decoration: none;
        }
        .hapus:hover {
            color: #1E0342;
        }
        .btn-transparant {
            background-color: white;
            color: #1A1A2E;
            border: 1px solid #1A1A2E;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.5s;
        }
        .btn-transparant:hover {
            background-color: #1A1A2E;
            color: white;
            border: none;
            padding: 10px 20px;
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Today's Activities</h1>
        </div>
        <?php
        $todos = [];

        // Jika file todo.txt ada, baca isinya dan unserialize untuk mendapatkan data yang sudah ada
        if(file_exists('todo.txt')){
            $file = file_get_contents('todo.txt');
            $todos = unserialize($file);
        }

        if(isset($_POST['todo'])){
            $data = $_POST['todo'];
            $todos[] = [
                'todo' => $data,
                'status' => 0
            ];
            // Simpan kembali array todos ke dalam file
            saveData($todos);
        }

        if(isset($_GET['status'])){
            $todos[$_GET['key']]['status'] = $_GET['status'];
            saveData($todos); 
        }

        if(isset($_GET['hapus'])){
            unset($todos[$_GET['key']]);
            saveData($todos); 
        }

        // Fungsi untuk menyimpan data todos ke file
        function saveData($todos){
            file_put_contents('todo.txt', serialize($todos));
            header('Location:index.php');
            exit(); 
        }
        ?>
        <form method="POST" class="form-group" style="display: flex; flex-direction: column; justify-content: center; align-items: stretch; max-width: 500px; margin: auto;">
    <label style="text-align: justify;">What are your activities today?</label>
    <br>
    <input type="text" name="todo" class="form-control" placeholder="Masukkan aktivitas hari ini..." style="margin-bottom: 10px;">
    <button type="submit" class="btn btn-transparant" style="align-self: flex-end;">Simpan</button>
</form>


        <ul class="todo-list">
            <?php foreach ($todos as $key => $value): ?>
            <li>
                <input type="checkbox" name="todo" onclick="window.location.href ='index.php?status=<?php echo ($value['status'] == 1) ? '0' : '1'; ?>&key=<?php echo $key; ?>'" <?php if($value['status'] == 1) echo 'checked'; ?> class="checkbox">
                <label>
                    <?php 
                        if ($value['status'] == 1)
                            echo '<del>' . $value['todo'] . '</del>';
                        else
                            echo $value['todo'];
                    ?>
                </label>
                <a href='index.php?hapus=1&key=<?php echo $key; ?>' onclick="return confirm('Apakah kamu yakin akan menghapus?')" class="hapus">hapus</a>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>