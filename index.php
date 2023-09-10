<?php
require_once 'manipulate_data.php'; 
?>
<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <title>Cálculo Salário Líquido</title>
</head> 
<body>
    <h1 class="title">Calculadora de Salário Líquido</h1>

   <div id="content">
   <div id="informationText">
            <p>Este cálculo retorna o salário líquido a partir do salário bruto e dos principais descontos do salário (INSS e IRRF).</p>
            <p class="continueText">Informe os dados solicitados nos campos a baixo.</p>
    </div>

        <div id="all">
        
                <form id="form" action="manipulate_data.php" method="POST">
                    <div >
                        <label for="grossSalary">Salário bruto  <img src="icon/info-circle.svg" alt="informações" data-toggle="tooltip" data-placement="top" title="Salário registrado na carteira de trabalho, remuneração que um trabalhador recebe por mês, sem considerar os descontos oficiais obrigatórios."></label>
                        <div class="span-input">
                            <span class="input-group-text">R$</span>
                            <input type="text" class="form-control" id="grossSalary" name="grossSalary"
                            aria-label="Dollar amount (with dot and two decimal places) " placeholder="0,00">
                        </div>
                    </div>
                    <div>
                        <label for="discount">Descontos  <img data-toggle="tooltip" data-placement="top" title="Descontos não oficiais e obrigatórios. Descontos alternativos acordados com a sua empresa ou determinação jurídica específca como pensão alimentícia." src="icon/info-circle.svg" alt="informações"></label>
                        <div class="span-input">
                            <span class="input-group-text">R$</span>
                            <input type="text" class="form-control" id="discount" name= "discount"
                                aria-label="Dollar amount (with dot and two decimal places)" placeholder="0,00">
                        </div>
                    </div>
                    <div >  
                        <label for="numDependents">Número de dependentes  <img src="icon/info-circle.svg" alt="informações" data-toggle="tooltip" data-placement="top" title="Pessoa da qual o trabalhador seja tutor ou curador. Pessoa que pode ser incluída no Imposto de Renda do trabalhador como dependente."></label>
                        <input type="text" class="form-control" id="numDependents" name= "numDependents" placeholder="0">
                    </div>
                    <br>
                    <div class="buttons">
                        <button type="button" class="btn btn-secondary"  id="clearButton">Limpar</button>
                        <button class="btn btn-primary" type="button" id="calculateButton">Calcular</button> 
                    </div>  
                </form>

                <div id="calculationResult">
        
                    <table class="table" id="salaryTable" style="display: none;">
                        <p style="display: none;" id="salaryTable">Resultado</p>
                        <tr>
                            <th>Eventos</th>
                            <th >Alíquota Real <img src="icon/info-circle.svg" alt="informações" data-toggle="tooltip" data-placement="top" title="Percentual do imposto sobre os rendimentos tributáveis.	"></th>
                            <th>Proventos</th>
                            <th>Descontos</th>
                        </tr>
                        <tr>
                            <td>Salário bruto</td>
                            <td> - </td>
                            <td>R$<?php echo $grossSalary; ?></td>
                            <td> - </td>
                        </tr>
                        <tr>
                            <td>Outros</td>
                            <td> - </td>
                            <td> - </td>
                            <td>R$<?php echo $discount; ?></td>
                        </tr>
                        <tr>
                            <td>INSS</td>
                            <td><?php echo $inss; ?>%</td>
                            <td> - </td>
                            <td>R$<?php echo $inssValue; ?></td>
                        </tr>
                        <tr>
                            <td>IRRF</td>
                            <td><?php echo $irrf; ?>%</td>
                            <td><?php echo $irrfValue; ?></td>
                            <td>R$<?php echo $irrfValue; ?></td>
                        </tr>
                        <tr>
                            <td>Totais</td>
                            <td>R$<?php echo $grossSalary; ?></td>
                            <td colspan="2">R$<?php echo ($grossSalary != 0) ? $discountTotal : 0; ?></td>
                        </tr>
                        <tr class="netSalary">
                            <td colspan="2">Valor salário líquido</td>
                            <td colspan="2">R$<?php echo ($grossSalary != 0) ? $netSalary : 0; ?></td>
                        </tr>
                    </table>
                </div>
            
        </div>
   </div>
</body>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.5/jquery.inputmask.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

<script>
    
    $(document).ready(function(){

    var moneyGrossSalary = $('#grossSalary');
    var moneyDiscount = $('#discount');

    moneyGrossSalary.mask('000.000.000.000.000,00', { reverse: true });
    moneyDiscount.mask('000.000.000.000.000,00', { reverse: true });
        
        $('#calculateButton').on('click', function(){
            var grossSalaryValue = moneyGrossSalary.val().replace(/\D/g, ''); 
            var discountValue = moneyDiscount.val().replace(/\D/g, ''); 
            
            grossSalaryValue = parseFloat(grossSalaryValue) / 100;
            discountValue = parseFloat(discountValue) / 100;

            var formData = {
                'grossSalary': grossSalaryValue,
                'discount': discountValue,
                'numDependents': $('#numDependents').val()
            };
            
            $.ajax({
                type: 'POST',
                url: 'manipulate_data.php',
                data: formData,
                success: function(response) {
                    $('#calculationResult').html(response);
                    $('#salaryTable').show();   
                    console.log(formData);  

                }
            });

        });

        $('#clearButton').on('click', function(){
            $('#grossSalary').val('');
            $('#discount').val('');
            $('#numDependents').val('');
            $('#salaryTable').hide();
        });

        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    });

</script>

</html>