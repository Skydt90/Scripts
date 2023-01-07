<?php require_once 'budget.php' ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Vedligeholdsoverblik</title>
    <style>
        html, body {
            height: 100%
        }
        body {
            display: grid;
            place-items: center;
        }
    </style>
</head>
<body>

    <div>
    <?php
        foreach ($budgets as $budget) {
            echo <<<HTML
                <h1>{$budget->getType()}</h1>
                <p><strong>Aktuel Saldo: </strong>{$budget->getTotalRemaining()} DKK</p>
                <p><strong>Månedsoverførsel: </strong> {$budget->getMonthlyAmount()} DKK</p>
                <p><strong>Total Årligt: </strong>{$budget->getYearlyAmount()} DKK</p>
                <p><strong>Total Forbrug: </strong>{$budget->getTotalSpent()} DKK</p>
                <p><strong>Total Opsparet: </strong>{$budget->getTotalSaved()} DKK</p>
                <p><strong>Opsparingsperiode: </strong>{$budget->getSavingPeriod()}</p>
            HTML;
        }
    ?> 
    </div> 
</body>
</html>