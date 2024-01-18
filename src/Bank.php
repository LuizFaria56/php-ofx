<?php

namespace LuizFaria\Ofx;

class Bank
{
   protected $dtServer;
   protected $organization;
   protected $branch;
   protected $account;

   public function getDtServer() { return $this->dtServer; }
   public function getOrganization() { return $this->organization; }
   public function getBranch() { return $this->branch; }
   public function getAccount() { return $this->account; }

   public function setDtServer($dtServer) { $this->dtServer = $dtServer; }
   public function setOrganization($organization) { $this->organization = $organization; }
   public function setBranch($branch) { $this->branch = $branch; }
   public function setAccount($account) { $this->account = $account; }

   public function __construct($dtServer, $organization, $branch, $account)
   {
      $this->setDtServer($dtServer);
      $this->setOrganization($organization);
      $this->setBranch($branch);
      $this->setAccount($account);
   }

}
