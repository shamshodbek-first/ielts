<?php
// JSON fayli orqali holatlarni saqlash va o'qish
$jsonFile = 'data.json';

// Fayl mavjud bo'lmasa, bo'sh ma'lumotlar bilan yarating
if (!file_exists($jsonFile)) {
    file_put_contents($jsonFile, json_encode([]));
}

// JSON fayldan holatlarni o'qing
$data = json_decode(file_get_contents($jsonFile), true);

// Checkbox holatlarini yangilash (faqat admin uchun)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    foreach ($_POST as $key => $value) {
        if ($key !== 'update') {
            $data[$key] = $value === 'on';
        }
    }
    file_put_contents($jsonFile, json_encode($data)); // JSON faylni yangilash
}

// Foydalanuvchi uchun faqat ma'lumotlarni ko'rsatish
function isAdmin() {
    // Admin paroli. Bu yerga o'zingizning maxfiy parolingizni kiriting.
    $adminPassword = 'yourpassword';
    return isset($_GET['admin']) && $_GET['admin'] === $adminPassword;
}
?>

<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IELTS Reja - 30 Kun</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f3f3;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: blue;
        }
        .day {
            margin-bottom: 20px;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 1px 5px rgba(0, 0, 0, 0.1);
        }
        .day h2 {
            margin: 0 0 10px;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            display: flex;
            align-items: center;
            padding: 8px 0;
        }
        input[type="checkbox"] {
            margin-right: 10px;
            transform: scale(1.2);
            cursor: pointer;
        }
        li.completed {
            text-decoration: line-through;
            color: #999;
        }
        .day:nth-child(5n+1) { background-color: #e3f2fd; }
        .day:nth-child(5n+2) { background-color: #fce4ec; }
        .day:nth-child(5n+3) { background-color: #f3e5f5; }
        .day:nth-child(5n+4) { background-color: #e8f5e9; }
        .day:nth-child(5n+5) { background-color: #fff3e0; }
    </style>
</head>
<body>
    <div class="container">
        <h1>SHAMSHODBEKNING IELTSGA TAYYORLOV REJASI - 30 KUN</h1>
        <form method="POST">
            <?php for ($day = 1; $day <= 30; $day++): ?>
                <div class="day">
                    <h2><?= $day ?>-kun</h2>
                    <ul>
                        <li>
                            <input type="checkbox" name="task<?= $day ?>_1" 
                                   <?= !empty($data["task{$day}_1"]) ? 'checked' : '' ?> 
                                   <?= isAdmin() ? '' : 'disabled' ?>> 
                            15 ta yangi so'z yodlash va ular bilan gaplar tuzish.
                        </li>
                        <li>
                            <input type="checkbox" name="task<?= $day ?>_2" 
                                   <?= !empty($data["task{$day}_2"]) ? 'checked' : '' ?> 
                                   <?= isAdmin() ? '' : 'disabled' ?>> 
                            Listeningdan 1 ta mashq bajarish.
                        </li>
                        <li>
                            <input type="checkbox" name="task<?= $day ?>_3" 
                                   <?= !empty($data["task{$day}_3"]) ? 'checked' : '' ?> 
                                   <?= isAdmin() ? '' : 'disabled' ?>> 
                            Writing Task 1 (150 so'zli chart tahlili).
                        </li>
                    </ul>
                </div>
            <?php endfor; ?>
            <?php if (isAdmin()): ?>
                <button type="submit" name="update">O'zgarishlarni Saqlash</button>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>
