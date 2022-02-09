<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <meta name="description" content="">
    <!-- appel cdn reset css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css" integrity="sha512-NmLkDIU1C/C88wi324HBc+S2kLhi08PN5GDeUVVVC/BVt/9Izdsc9SVeVfA1UZbY3sHUlDSyRXhCzHfr6hmPPw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- appel de boostrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- appel cdn fontawesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
    <!-- appel dosier css -->
    <link rel="stylesheet" href="./assets/styles.css">
    <!-- appel dossier JavaScript -->
    <script async src="./assets/js/script.js"></script>
</head>
<?php

$DayWeeks = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
$months = [1 => 'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Décembre', ' '];

$defaultMonth = date('n');
$defaultYears = date('Y');
echo $defaultMonth, $defaultYears;

if($_GET['months'] == false){
    $numberMonth = $defaultMonth;
}

$numberMonth = $_GET['months'];
$numberYears = $_GET['years'];





function nextMonth($numberMonth, $numberYears){
    $nextMonth = $numberMonth + 1;
    if($nextMonth > 12){
        $nextMonth = 1;
        $numberYears++;
    }
    return "http://php.test/TP-calendrier/?months=$nextMonth&years=$numberYears";
}

function prevMonth($numberMonth, $numberYears){
    $nextMonth = $numberMonth - 1;
    if($nextMonth < 1){
        $nextMonth = 12;
        $numberYears--;
    }
    return "http://php.test/TP-calendrier/?months=$nextMonth&years=$numberYears";
}







?>

<body>
    <!---------------------------------------------------------------Header------------------------------------------------------------->
    <header class="content-header">
        <div class="wrapper-header">
            <div class="title-icon">
                <div><a href="<?php echo prevMonth($numberMonth, $numberYears) ?>"><i class="fas fa-chevron-left"></i></a></div>
                <h1 class="title-month"><?php echo $months[$_GET['months']], ' ', $_GET['years'] ?></h1>
                <div><a href="<?php echo nextMonth($numberMonth, $numberYears) ?>"><i class="fas fa-chevron-right"></i></a></div>
            </div>

            <form action="" method="GET" class="wrapper-form">
                <select name="months" class="select-month">
                    <?php
                    for ($month = 1; $month < count($months); $month++) {

                        if ($month == $_GET['months']) {
                            echo '<option value="' . $month . '" selected>' . $months[$month] . '</option>';
                        } else {
                            echo '<option value="' . $month . '">' . $months[$month] . '</option>';
                        }
                    }

                    ?>
                </select>

                <select name="years" class="select-years">
                    <?php
                    for ($years = 1970; $years <= 2030; $years++) {

                        if ($years == $_GET['years']) {
                            echo '<option value="' . $years . '" selected>' . $years . '</option>';
                        } else {
                            echo '<option value="' . $years . '">' . $years . '</option>';
                        }
                    }
                    ?>
                </select>
                <button type="submit" class="btn-valid">Valider</button>
            </form>
        </div>
    </header>
    <!---------------------------------------------------------------Fin header------------------------------------------------------------->



    <!---------------------------------------------------------------Contenu principal------------------------------------------------------------->
    <main class="site-content">
        <div class="wrapper-content">
            <table>
                <thead class="thead-table">
                    <?php

                    $rowB = '<tr>';
                    $rowE = '</tr>';
                    echo $rowB;
                    for ($i = 0; $i < count($DayWeeks); $i++) {
                        echo '<th class="week">' . $DayWeeks[$i] . '</th>';
                    }
                    echo $rowE;

                    ?>

                </thead>
                <tbody class="tbody-table">
                    <?php



                    $firstNumber = new DateTime($numberYears . '-' . $numberMonth . '-01');
                    $dayNumber = $firstNumber->format('N');
                    // echo $dayNumber;

                    $nbrMonth = new DateTime($numberYears . '-' . $numberMonth . '-' . $dayNumber);
                    $nextNumber = $nbrMonth->format('N');

                    // date_add($firstNumber, date_interval_create_from_date_string('-1 days'));
                    // echo date_format($firstNumber,"d");

                    $count = 0;
                    $rowB = '<tr>';
                    $rowE = '</tr>';

                    $numberInMonth = cal_days_in_month(CAL_GREGORIAN, $numberMonth, $numberYears);



                    echo $rowB;
                    for ($i = 1; $i <= $numberInMonth + $dayNumber - 1; $i++) {
                        $count++;
                        if ($i == $dayNumber) {
                            $d = 1;
                        }

                        if ($i >= $dayNumber) {
                            echo '<td class="dayWeek">' . $d . '</td>';
                            $d++;
                            if ($count > 6) {
                                $count = 0;
                                echo $rowE;
                                echo $rowB;
                            }
                        } 

                        elseif ($i <= $dayNumber) {
                            $arrayDay = [];

                            $prevDays = date_modify($firstNumber, ('-1 days'));
                            $dayPrevNumber = date_format($prevDays, "d");
                            array_push($arrayDay, $dayPrevNumber);
                            $reverse = array_reverse($arrayDay);

                            // print_r(array_reverse($reverse));

                            for ($t = 0; $t < count($reverse); $t++) {
                                echo '<td class="dayPrevWeek">' . $reverse[$t] . '</td>';
                            }
                        }

            
                    }


                    // $a = $dayNumber - 1;
                    // $arrayDay = [];

                    // while ($a <= 1) {
                    //     $prevDays = date_modify($firstNumber, ('-1 days'));
                    //     $dayPrevNumber = date_format($prevDays, "d");
                    //     array_push($arrayDay, $dayPrevNumber);
                    //     $a--;
                    // }
                    // $reverse = array_reverse($arrayDay);
                    // print_r(array_reverse($reverse));

                    // for ($t = 0; $t < count($reverse); $t++) {
                    //     echo '<td class="dayPrevWeek">' . $reverse[$t] . '</td>';
                    // }







                    ?>
                </tbody>
            </table>
        </div>

    </main>
    <!---------------------------------------------------------------Fin contenu------------------------------------------------------------->



    <!---------------------------------------------------------------Footer------------------------------------------------------------->
    <footer class="content-footer">

    </footer>

</body>

</html>