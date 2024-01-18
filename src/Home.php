<?php

namespace App\Controller;

use DateTime;
use Bank;

class Home
{

   public function index($path)
   {
      # ler arquivo
      //$path = DIR_PROJECT . '/doc/extratoBB202401.ofx';
      $file = fopen($path, 'r');
      $bank = array();
      $list = array();
      $aux = array();
      $trans = 'B'; // [B]efore, [S]tart, [E]nd, [A]fter
      while(!feof($file)) {
         $line = trim(fgets($file));
         if(strpos($line, '<DTSERVER>') !== false) {
            $dtServer = DateTime::createFromFormat('YmdHis', substr($line, 10, 14));
            $bank['dt_server'] = $dtServer;
         }
         if(strpos($line, '<ORG>') !== false) {
            $org = ltrim(rtrim($line,'</ORG>'), '<ORG>');
            $bank['org'] = $org;
         }
         if(strpos($line, '<BRANCHID>') !== false) {
            $branch = ltrim(rtrim($line, '</BRANCHID>'), '<BRANCHID>');
            $bank['branch'] = $branch;
         }
         if(strpos($line, '<ACCTID>') !== false) {
            $acct = ltrim(rtrim($line, '</ACCTID>'), '<ACCTID>');
            $bank['acct'] = $acct;
            $bank = new Bank($bank['dt_server'], $bank['org'], $bank['branch'], $bank['acct']);
         }
         if(strpos($line, '<BANKTRANLIST>') !== false) {
            $trans = 'S'; //Start
         }
         if($trans == 'S') {
            if(strpos($line, '<TRNTYPE>') !== false) {
               $type = ltrim(rtrim($line, '</TRNTYPE>'), '<TRNTYPE>');
               $aux['type'] = $type;
            }
            if(strpos($line, '<DTPOSTED>') !== false) {
               $dtPosted = DateTime::createFromFormat('YmdHis', substr($line, 10, 14));
               $aux['dt_posted'] = $dtPosted;
            }
            if(strpos($line, '<TRNAMT>') !== false) {
               $amount = ltrim(rtrim($line, '</TRNAMT>'), '<TRNAMT>');
               $aux['amount'] = $amount;
            }
            if(strpos($line, '<MEMO>') !== false) {
               $memo = ltrim(rtrim($line, '</MEMO>'), '<MEMO>');
               $aux['memo'] = $memo;
               $list[] = $aux;
               $aux = array();
            }
            if(strpos($line, '</BANKTRANLIST>') !== false) {
               $trans = 'E'; //End
            }
         }
      }
      fclose($file);
      echo '<!DOCTYPE html>' . PHP_EOL;
      echo '<html lang="en">' . PHP_EOL;
      echo '<head>' . PHP_EOL;
      echo '   <meta charset="UTF-8">' . PHP_EOL;
      echo '   <meta name="viewport" content="width=device-width, initial-scale=1.0">' . PHP_EOL;
      echo '   <title>Document</title>' . PHP_EOL;
      echo '</head>' . PHP_EOL;
      echo '<body>' . PHP_EOL;
      echo '   <h3>Resultado</h3>' . PHP_EOL;
      echo '   <p>' . $bank->getOrganization() . ": " . $bank->getBranch() . ' - ' . $bank->getAccount() . '</p>' . PHP_EOL;
      foreach($list as $key => $value) {
         $dtValue = $value['dt_posted'];
         echo '   <p>' . $dtValue->format('d/m/Y') . ' | ' . $value['memo'] . ' | ' . $value['amount'] . PHP_EOL;
         echo '' . PHP_EOL;
         echo '' . PHP_EOL;
         echo '' . PHP_EOL;
         echo '' . PHP_EOL;   
      }
      echo '</body>' . PHP_EOL;
      echo '</html>' . PHP_EOL;
   }

}
