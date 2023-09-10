<?php
$inss = 0;
$irrf = 0;
$grossSalary = 0;
$discount = 0;
$numDependents = 0;
$inssValue = 0;
$irrfValue = 0;
$netSalary=0;

if (isset($_POST['grossSalary'])) {
    $grossSalary = floatval($_POST["grossSalary"]);
}

if (isset($_POST['numDependents'])) {
    $numDependents = floatval($_POST["numDependents"]);
}

if (isset($_POST['discount'])) {
    $discount = floatval($_POST["discount"]);
}

if ($grossSalary <= 1302) {
    $inss = 7.5;
} elseif ($grossSalary <= 2571.29) {
    $inss = 9;
} elseif ($grossSalary <= 3856.94) {
    $inss = 12;
} elseif ($grossSalary <= 7507.49) {
    $inss = 14;
} elseif ($grossSalary <= 12856.50) {
    $inss = 14.5;
} elseif ($grossSalary <= 25712.99) {
    $inss = 16.5;
} elseif ($grossSalary <= 50140.33) {
    $inss = 19;
} else {
    $inss = 22;
}

if ($grossSalary > 0) {
    $inssValue = $grossSalary * ($inss / 100);
    $netSalary = $grossSalary - $inssValue - ( $numDependents*189.59);
}

if (($netSalary > 1903.98) && ($netSalary < 2826.66)){
    $irrf= 7.5;
    $irrfValue = ($netSalary * ($irrf / 100)) - 142.80;
} elseif (($netSalary > 2826.66) && ($netSalary < 3751.06)){
    $irrf= 15;
    $irrfValue = ($netSalary * ($irrf / 100)) - 354.80;
} elseif (($netSalary > 3751.06) && ($netSalary < 4664.68)){
    $irrf=22.5;
    $irrfValue = ($netSalary * ($irrf / 100)) - 636.13;
} elseif ($netSalary > 4664.68){
    $irrf=27.5;
    $irrfValue = ($netSalary * ($irrf / 100)) - 869.36;
}

if ($grossSalary > 0) {
    $discountTotal = $discount + $inssValue + $irrfValue;
    $netSalary = $grossSalary - $discountTotal;
    //formatação
    $netSalary = number_format($netSalary, 2, ',', '.');
    $discountTotal = number_format($discountTotal, 2, ',', '.');
    $discount = number_format($discount, 2, ',', '.');
    $grossSalary = number_format($grossSalary, 2, ',', '.');
    $irrfValue = number_format($irrfValue, 2, ',', '.');
    $inssValue = number_format($inssValue, 2, ',', '.');
}

if ($grossSalary > 0) {
    echo '<table class="table" id="salaryTable">';
    echo '<tr>';
    echo '<th>Eventos</th>';
    echo '<th>Alíquota Real  <img src="icon/info-circle.svg" alt="informações" data-toggle="tooltip" data-placement="top" title="Percentual do imposto sobre os rendimentos tributáveis.	"></th>';
    echo '<th>Proventos</th>';
    echo '<th>Descontos</th>';
    echo '</tr>';
    echo '<tr>';
    echo '<td>Salário bruto</td>';
    echo '<td> - </td>';
    echo '<td>R$' . $grossSalary . '</td>';
    echo '<td> - </td>';
    echo '</tr>';
    echo '<tr>';
    echo '<td>Outros</td>';
    echo '<td> - </td>';
    echo '<td> - </td>';
    echo '<td>R$' . $discount . '</td>';
    echo '</tr>';
    echo '<tr>';
    echo '<td>INSS</td>';
    echo '<td>' . $inss . '%</td>';
    echo '<td> - </td>';
    echo '<td>R$' . $inssValue . '</td>';
    echo '</tr>';
    echo '<tr>';
    echo '<td>IRRF</td>';
    echo '<td>' . $irrf . '%</td>';
    echo '<td> - </td>';
    echo '<td>R$' . $irrfValue . '</td>';
    echo '</tr>';
    echo '<tr>';
    echo '<td>Totais</td>';
    echo '<td>R$' . $grossSalary . '</td>';
    echo '<td colspan="2">R$' . $discountTotal . '</td>';
    echo '</tr>';
    echo '<tr class="netSalary">';
    echo '<td colspan="2">Valor salário líquido</td>';
    echo '<td colspan="2">R$' . $netSalary . '</td>';
    echo '</tr>';
    echo '</table>';
}
?>