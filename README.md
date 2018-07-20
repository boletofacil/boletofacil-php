# BoletoBancario.com - Boleto Fácil
## SDK para integração com o Boleto Fácil

Para verificar a documentação completa e os exemplos de resposta, acesse o <a href="https://www.boletobancario.com/boletofacil/integration/integration.html" target="_blank">Manual de Integração</a>.



## Como usar: ##

Baixe e coloque o arquivo **boletofacil.php** no mesmo diretorio do arquivo PHP que irá implementar.
Após isso, importe o arquivo em seu projeto e inicialize usando seu <a href="https://www.boletobancario.com/boletofacil/integration/integration.html#token" target="_blank">Token de integração</a>:

```php
require 'boletofacil.php';
use BoletoFacil\BoletoFacil;

$boletoFacil = new BoletoFacil("SEU_TOKEN");
```



## Gerar cobrança mínima: ##

Chame o metodo **createCharge** para gerar uma cobrança com os dados mínimos:

```php
$boletoFacil->createCharge("Junior Barros", "CPF_DO_CLIENTE", "Pedido 48192", "147.36", "07/11/2017");
```



## Gerar cobrança: ##

Chame o metodo **createCharge** para gerar uma cobrança com os dados mínimos, e depois adicione mais atributos a cobrança, como por exemplo parcelas e o email do cliente (para envio automatico do email):

```php
$boletoFacil->createCharge("Junior Barros", "CPF_DO_CLIENTE", "Pedido 48192", "1047.36", "07/11/2017");
$boletoFacil->installments = 10;
$boletoFacil->payerEmail = "junior@boletobancario.com";
```



## Emitir cobrança: ##

Após gerar uma cobrança, você deverá chamar o método **issueCharge** para emitir a cobrança:

```php
$boletoFacil->createCharge("Junior Barros", "CPF_DO_CLIENTE", "Pedido 48192", "147.36", "07/11/2017");
$boletoFacil->payerEmail = "junior@boletobancario.com";

$boletoFacil->issueCharge();
```



## Notificação de pagamentos ##

Você pode configurar o Boleto Fácil para enviar notificações para seu sistema sempre que houver um evento de pagamento.
Para isso, faça login no <a href="https://www.boletobancario.com/boletofacil/user/login.html" target="_blank">Boleto Fácil</a>, e acesse a página de integração <a href="https://www.boletobancario.com/boletofacil/integration/integration.html#notificacao" target="_blank">Notificação de pagamentos</a>.




## Consulta de pagamentos: ##

Após receber uma notificação de pagamento, seu sistema pode utilizar o paymentToken recebido para consultar detalhes do pagamento:

```php
require 'boletofacil.php';
use BoletoFacil\BoletoFacil;

$boletoFacil = new BoletoFacil("SEU_TOKEN");
$boletoFacil->fetchPaymentDetails("PAYMENT_TOKEN");
```




## Consulta de saldo: ##

Você pode verificar seu saldo através do método:

```php
require 'boletofacil.php';
use BoletoFacil\BoletoFacil;

$boletoFacil = new BoletoFacil("SEU_TOKEN");
$boletoFacil->fetchBalance();
```




## Solicitação de transferência: ##

Você pode solicitar a transferência dos valores em saldo usando o seguinte método:

```php
require 'boletofacil.php';
use BoletoFacil\BoletoFacil;

$boletoFacil = new BoletoFacil("SEU_TOKEN");
$boletoFacil->requestTransfer();
```

Para definir o valor a ser transferido:

```php
require 'boletofacil.php';
use BoletoFacil\BoletoFacil;

$boletoFacil = new BoletoFacil("SEU_TOKEN");
$boletoFacil->transferAmount = "147.36";
$boletoFacil->requestTransfer();
```


## Cancelamento de cobrança: ##

Para arquivar e cancelar os lembretes de uma cobrança, use o método:

```php
require 'boletofacil.php';
use BoletoFacil\BoletoFacil;

$boletoFacil = new BoletoFacil("SEU_TOKEN");
$boletoFacil->cancelCharge("CODIGO_DA_COBRANCA");
```


Para verificar a documentação completa e os exemplos de resposta, acessar <a href="https://www.boletobancario.com/boletofacil/integration/integration.html" target="_blank">Manual de Integração</a>.
