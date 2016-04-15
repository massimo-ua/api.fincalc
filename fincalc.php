<?php
class FinancialCalculator {
	//Incoming Values
	private $InOBCashAndEquivalentsSTandLTMarketSecurities;
	private $InDEBTHistoryInterestRateOnCash;
	private $InCSSBC;
	private $InWCAR;
	private $InOBAccountsReceivable;
	private $InOBInventory;
	private $InWCInventory;
	private $InWCAP;
	private $InOBAccountsPayable;
	private $InOBAccruedExpenses;
	private $InWCAccruedExpenses;
	private $InLDTOtherCurrentAssets;
	private $InLDTDeferredTaxAssets;
	private $InLDTOtherAssets;
	private $InLDTAccruedExpensesAndDefRevenues;
	private $InDEBTPIKAccrual;
	private $InWCCapitalExpenditures;
	private $InWCPurchasesOfIntangibleAssets;
	private $InDEBTAdditionalBorrowingOrPayDown;
	private $InREDividends;
	private $InCSNewShareIssuance;
	private $InCSStockRepurchases;
	private $InPLOtherComprehensiveIncomeOrLoss;
	private $InPLBlendedTaxRate;
	private $InPLOtherExpense;
	private $InISResearchAndDevelopment;
	private $InISSellingGeneralAndAdministrative;
	private $InISCostOfSales;
	private $InDEBTInterestExpenseOnLongTermDebt;
	private $InRCEndOfPeriod;
	private $InDEBTInterestRateOnRevolver;
	private $InDEBTRevolverMinimumCashDesired;
	private $InIAAmortization;
	private $InPSData;
	//Calculated intermediate values
	private $LoopCounter=1;

	//output values
	public $OutCFCashFromOperatingActivities;
	public $OutCFCashFromInvestingActivities;
	public $OutRCInterestIncome=0;
	public $OutISOperatingProfitEBIT;

	function __construct(
	$InOBCashAndEquivalentsSTandLTMarketSecurities,
	$InDEBTHistoryInterestRateOnCash,
	$InCSSBC,
	$InWCAR,
	$InOBAccountsReceivable,
	$InOBInventory,
	$InWCInventory,
	$InWCAP,
	$InOBAccountsPayable,
	$InOBAccruedExpenses,
	$InWCAccruedExpenses,
	$InLDTOtherCurrentAssets,
	$InLDTDeferredTaxAssets,
	$InLDTOtherAssets,
	$InLDTAccruedExpensesAndDefRevenues,
	$InDEBTPIKAccrual,
	$InWCCapitalExpenditures,
	$InWCPurchasesOfIntangibleAssets,
	$InDEBTAdditionalBorrowingOrPayDown,
	$InREDividends,
	$InCSNewShareIssuance,
	$InCSStockRepurchases,
	$InPLOtherComprehensiveIncomeOrLoss,
	$InPLBlendedTaxRate,
	$InPLOtherExpense,
	$InISResearchAndDevelopment,
	$InISSellingGeneralAndAdministrative,
	$InISCostOfSales,
	$InDEBTInterestExpenseOnLongTermDebt,
	$InRCEndOfPeriod,
	$InDEBTInterestRateOnRevolver,
	$InDEBTRevolverMinimumCashDesired,
	$InIAAmortization,

	$InPSData) {
			$this->InOBCashAndEquivalentsSTandLTMarketSecurities = $InOBCashAndEquivalentsSTandLTMarketSecurities;
			$this->InDEBTHistoryInterestRateOnCash = $InDEBTHistoryInterestRateOnCash;
			$this->InCSSBC = $InCSSBC;
			$this->InWCAR = $InWCAR;
			$this->InOBAccountsReceivable = $InOBAccountsReceivable;
			$this->InOBInventory = $InOBInventory;
			$this->InWCInventory = $InWCInventory;
			$this->InWCAP = $InWCAP;
			$this->InOBAccountsPayable = $InOBAccountsPayable;
			$this->InOBAccruedExpenses = $InOBAccruedExpenses;
			$this->InWCAccruedExpenses = $InWCAccruedExpenses;
			$this->InLDTOtherCurrentAssets = $InLDTOtherCurrentAssets;
			$this->InLDTDeferredTaxAssets = $InLDTDeferredTaxAssets;
			$this->InLDTOtherAssets = $InLDTOtherAssets;
			$this->InLDTAccruedExpensesAndDefRevenues = $InLDTAccruedExpensesAndDefRevenues;
			$this->InDEBTPIKAccrual = $InDEBTPIKAccrual;
			$this->InWCCapitalExpenditures = $InWCCapitalExpenditures;
			$this->InWCPurchasesOfIntangibleAssets = $InWCPurchasesOfIntangibleAssets;
			$this->InDEBTAdditionalBorrowingOrPayDown = $InDEBTAdditionalBorrowingOrPayDown;
			$this->InREDividends = $InREDividends;
			$this->InCSNewShareIssuance = $InCSNewShareIssuance;
			$this->InCSStockRepurchases = $InCSStockRepurchases;
			$this->InPLOtherComprehensiveIncomeOrLoss = $InPLOtherComprehensiveIncomeOrLoss;
			$this->InPLBlendedTaxRate = $InPLBlendedTaxRate;
			$this->InPLOtherExpense = $InPLOtherExpense;
			$this->InISResearchAndDevelopment = $InISResearchAndDevelopment;
			$this->InISSellingGeneralAndAdministrative = $InISSellingGeneralAndAdministrative;
			$this->InISCostOfSales = $InISCostOfSales;
			$this->InDEBTInterestExpenseOnLongTermDebt = $InDEBTInterestExpenseOnLongTermDebt;
			$this->InRCEndOfPeriod = $InRCEndOfPeriod;
			$this->InDEBTInterestRateOnRevolver =$InDEBTInterestRateOnRevolver;
			$this->InDEBTRevolverMinimumCashDesired = $InDEBTRevolverMinimumCashDesired;
			$this->InIAAmortization = $InIAAmortization;

			$this->InPSData = $InPSData;
	}

	public function OutRCInterestIncome() {
		$result = ($this->InOBCashAndEquivalentsSTandLTMarketSecurities + $this->OutBSCashAndEquivalentsSTandLTMarketSecurities())*$this->InDEBTHistoryInterestRateOnCash/200;
		//check for exit condition
		/*if (abs($result - $this->OutRCInterestIncome) < 0.05) {
			return $result;
		}
		else {
			$this->OutRCInterestIncome = $result;
			$this->OutRCInterestIncome();
		}*/
		//loop 100 times
		if($this->LoopCounter <= 100) {
			$this->LoopCounter++;
			echo $this->LoopCounter;
			$this->OutRCInterestIncome = $result;
			$this->OutRCInterestIncome();
		}
		else return $result;

	}
	private function OutBSCashAndEquivalentsSTandLTMarketSecurities() {
			return $this->InOBCashAndEquivalentsSTandLTMarketSecurities + $this->OutCFNetChangeInCashDuringPeriod();
	}
	private function OutCFNetChangeInCashDuringPeriod() {
		return $this->OutCFCashFromOperatingActivities() + $this->OutCFCashFromInvestingActivities() + $this->OutCFCashFromFinancingActivities();
	}
	//reusable
	private function OutCFCashFromOperatingActivities() {
		echo __class__ . '::' . __function__.'<br>';
		$this->OutCFCashFromOperatingActivities =		$this->OutCFNetIncome()
													  + $this->OutISDepreciationAndAmortization()
													  + $this->InCSSBC
													  - ($this->InWCAR - $this->InOBAccountsReceivable)
													  - ($this->InWCInventory - $this->InOBInventory)
													  + ($this->InWCAP - $this->InOBAccountsPayable)
													  + ( $this->InWCAccruedExpenses - $this->InOBAccruedExpenses)
													  - $this->InLDTOtherCurrentAssets
													  - $this->InLDTDeferredTaxAssets
													  - $this->InLDTOtherAssets
													  + $this->InLDTAccruedExpensesAndDefRevenues
													  + $this->InDEBTPIKAccrual;
		return $this->OutCFCashFromOperatingActivities;
	}

	private function OutCFCashFromInvestingActivities() {
		$this->OutCFCashFromInvestingActivities = $this->InWCPurchasesOfIntangibleAssets - $this->InWCCapitalExpenditures;
		return $this->OutCFCashFromInvestingActivities;
	}
	private function OutCFCashFromFinancingActivities() {
		return 		$this->InDEBTAdditionalBorrowingOrPayDown
						+ $this->$InREDividends
						+ $this->InCSNewShareIssuance
						+ $this->$InCSStockRepurchases
						+ $this->$InPLOtherComprehensiveIncomeOrLoss;
	}
	private function OutCFNetIncome() {
		return $this->OutISTaxes() + $this->OutISPretaxProfit();
	}

	private function OutISDepreciationAndAmortization() {
		return -($this->OutPPETotalDepreciation() + $this->InIAAmortization);
	}

	private function OutPPETotalDepreciation() {
		1/0;
	}

	private function OutISTaxes() {
		return - $this->OutISPretaxProfit() * $this->InPLBlendedTaxRate / 100;
	}
	private function OutISPretaxProfit() {
		return 		$this->OutISOperatingProfitEBIT()
						+ $this->OutRCInterestIncome
						+ $this->OutISInterestExpense()
						+ $this->InPLOtherExpense;
	}
	//reusable
	private function OutISOperatingProfitEBIT() {
		$this->OutISOperatingProfitEBIT = 		$this->OutISGrossProfit()
																				+	$this->InISResearchAndDevelopment
																				+ $this->InISSellingGeneralAndAdministrative;


	}
	private function OutISInterestExpense() {
		return -($this->InDEBTInterestExpenseOnLongTermDebt + $this->OutRCInterestExpense());
	}
	private function OutRCInterestExpense() {
		return ( $this->OutRCEndOfPeriod() + $this->InRCEndOfPeriod ) * $this->InDEBTInterestRateOnRevolver / 200;
	}
	private function OutRCEndOfPeriod() {
		return $this->InRCEndOfPeriod - min( $this->InRCEndOfPeriod, $this->OutRCEqualsCashAvailableToPaydownRevolver() );
	}

	private function OutRCEqualsCashAvailableToPaydownRevolver() {
		return $this->OutRCFreeCashFlowsGeneratedDuringPeriod() + $this->OutRCExcessCashAtBOP();
	}

	private function OutRCFreeCashFlowsGeneratedDuringPeriod() {
		return $this->OutCFCashFromOperatingActivities + $this->OutCFCashFromInvestingActivities + $this->InDEBTAdditionalBorrowingOrPayDown + $this->InPLOtherComprehensiveIncomeOrLoss;
	}

	private function OutRCExcessCashAtBOP() {
		return   $this->InOBCashAndEquivalentsSTandLTMarketSecurities - $this->InDEBTRevolverMinimumCashDesired;
	}

	private function OutISGrossProfit() {
		return $this->OutPSTotalHistorySales() + $this->InISCostOfSales;
	}

	private function OutPSTotalHistorySales() {
		$total = 0;
		foreach ($this->InPSData as $product) {
			$total += $product->InPSForcastedSales * $product->InPSForcasedProductionUnits / 1000;
		}
		return $total;
	}

}
