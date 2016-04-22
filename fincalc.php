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
	private $InPPEFiscalPeriod;
	private $InWCGrossPPandEBOP;
	private $InWCNonDepreciablePPandEBOP;
	private $InOBPropertyPlantAndEquipment;
	private $InPLHistoryDepreciationAndAmortization;
	private $InISBasicSharesOutstanding;
	private $InOBMarketSharePrice;
	private $InPLDilutedSharesOutstanding;
	private $InPLTaxes;
	private $InPSData;
	private $InPPEAverageUsefulLifeOverride = NULL;
	//static input values
	private $InPPEMidYearAdjustment = 0.5;
	//Calculated intermediate values
	private $LoopCounter=1;

	//output values
	public $OutCFCashFromOperatingActivities;
	public $OutCFCashFromInvestingActivities;
	public $OutRCInterestIncome=0;
	public $OutISOperatingProfitEBIT;
	public $OutPPEAverageUsefulLife;
	public $OutSOAverageSharePrice;
	public $OutISDilutedEPS;
	public $OutSOChangeInEPSYearOverYear;

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
	$InPPEFiscalPeriod,
	$InWCGrossPPandEBOP,
	$InWCNonDepreciablePPandEBOP,
	$InOBPropertyPlantAndEquipment,
	$InPLHistoryDepreciationAndAmortization,
	$InISBasicSharesOutstanding,
	$InOBMarketSharePrice,
	$InPLDilutedSharesOutstanding,
	$InPLTaxes,
	$InPSData,
	$InPPEAverageUsefulLifeOverride) {
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
			$this->InPPEFiscalPeriod = $InPPEFiscalPeriod; // calculation period (i.e. if start year is 2015 and current calculation year is 2017 then value is 2)
			$this->InWCGrossPPandEBOP = $InWCGrossPPandEBOP;
			$this->InWCNonDepreciablePPandEBOP = $InWCNonDepreciablePPandEBOP;
			$this->InOBPropertyPlantAndEquipment = $InOBPropertyPlantAndEquipment;
			$this->InPLHistoryDepreciationAndAmortization = $InPLHistoryDepreciationAndAmortization;
			$this->InISBasicSharesOutstanding = $InISBasicSharesOutstanding;
			$this->InOBMarketSharePrice = $InOBMarketSharePrice;
			$this->InPLDilutedSharesOutstanding = $InPLDilutedSharesOutstanding;
			$this->InPLTaxes = $InPLTaxes;
			$this->InPSData = $InPSData;
			$this->InPPEAverageUsefulLifeOverride = $InPPEAverageUsefulLifeOverride;
	}


	private function OutPSTotalHistorySales() {
		//Parameter OutPSTotalHistorySales / ISOutRevenue
		$total = 0;
		foreach ($this->InPSData as $product) {
			$total += $product->InPSForcastedSales * $product->InPSForcasedProductionUnits / 1000;
		}
		return $total;
	}

	private function OutISGrossProfit() {
		//Parameter OutISGrossProfit
		return $this->OutPSTotalHistorySales() + $this->InISCostOfSales;
	}


	private function OutISOperatingProfitEBIT() {
 		//reusable
		//Parameter OutISOperatingProfitEBIT
		if(isset($this->OutISOperatingProfitEBIT)) return $this->OutISOperatingProfitEBIT;
		$this->OutISOperatingProfitEBIT = 		$this->OutISGrossProfit()
																				+	$this->InISResearchAndDevelopment
																				+ $this->InISSellingGeneralAndAdministrative;
		return $this->OutISOperatingProfitEBIT;
	}

	public function OutRCInterestIncome() {
	//var_dump('3');exit(0);
		//Parameter OutRCInterestIncome
		$this->OutRCInterestIncome = ($this->InOBCashAndEquivalentsSTandLTMarketSecurities + $this->OutBSCashAndEquivalentsSTandLTMarketSecurities())*$this->InDEBTHistoryInterestRateOnCash/200;
		//check for exit condition
		/*if (abs($result - $this->OutRCInterestIncome) < 0.05) {
			return $result;
		}
		else {
			$this->OutRCInterestIncome = $result;
			$this->OutRCInterestIncome();
		}*/
		//loop 100 times
		//var_dump($result);
		if($this->LoopCounter <= 1) {
			$this->LoopCounter++;
			return $this->OutRCInterestIncome();
		}
		else {

			return $this->OutRCInterestIncome;
		}

	}


			private function OutBSCashAndEquivalentsSTandLTMarketSecurities() {
					return $this->InOBCashAndEquivalentsSTandLTMarketSecurities + $this->OutCFNetChangeInCashDuringPeriod();
			}

					private function OutCFNetChangeInCashDuringPeriod() {
							return $this->OutCFCashFromOperatingActivities() + $this->OutCFCashFromInvestingActivities() + $this->OutCFCashFromFinancingActivities();
					}

							private function OutCFCashFromFinancingActivities() {

									return 		$this->InDEBTAdditionalBorrowingOrPayDown
										+ $this->InREDividends
										+ $this->InCSNewShareIssuance
										+ $this->InCSStockRepurchases
										+ $this->InPLOtherComprehensiveIncomeOrLoss;
							}

							private function OutCFCashFromInvestingActivities() {
								if(isset($this->OutCFCashFromInvestingActivities)) return $this->OutCFCashFromInvestingActivities;
								$this->OutCFCashFromInvestingActivities = $this->InWCPurchasesOfIntangibleAssets - $this->InWCCapitalExpenditures;
								return $this->OutCFCashFromInvestingActivities;
							}


							private function OutCFCashFromOperatingActivities() {
									//reusable
									//echo __class__ . '::' . __function__.'<br>';
									if(isset($this->OutCFCashFromOperatingActivities)) return $this->OutCFCashFromOperatingActivities;
									$this->OutCFCashFromOperatingActivities =		$this->OutCFNetIncome()
																	  + $this->OutISDepreciationAndAmortization()
																	  + $this->InCSSBC
																	  - ($this->InWCAR - $this->InOBAccountsReceivable)
																	  - ($this->InWCInventory - $this->InOBInventory)
																	  + ($this->InWCAP - $this->InOBAccountsPayable)
																	  + ($this->InWCAccruedExpenses - $this->InOBAccruedExpenses)
																	  - $this->InLDTOtherCurrentAssets
																	  - $this->InLDTDeferredTaxAssets
																	  - $this->InLDTOtherAssets
																	  + $this->InLDTAccruedExpensesAndDefRevenues
																	  + $this->InDEBTPIKAccrual;
									return $this->OutCFCashFromOperatingActivities;
							}

									private function OutCFNetIncome() {
										return $this->OutISTaxes() + $this->OutISPretaxProfit();
									}


											private function OutISTaxes() {
												return - $this->OutISPretaxProfit() * $this->InPLBlendedTaxRate / 100;
											}

											private function OutISPretaxProfit() {
												if(isset($this->OutISPretaxProfit)) return $this->OutISPretaxProfit;
												$this->OutISPretaxProfit =		$this->OutISOperatingProfitEBIT()
																										+ $this->OutRCInterestIncome
																										+ $this->OutISInterestExpense()
																										+ $this->InPLOtherExpense;
												return $this->OutISPretaxProfit;
											}

								private function OutISDepreciationAndAmortization() {
									return -($this->OutPPETotalDepreciation() + $this->InIAAmortization);
								}

										 private function OutPPETotalDepreciation() {
												$result = $this->OutPPEDepreciationFromExistingPPAndE();
												foreach($this->OutPPEDepreciationFromCapexPurchased() as $value) {
													$result += $value;
												}
												return -$result;
										 }

													private function OutPPEDepreciationFromExistingPPAndE() {
														//АСЧ(нач_стоимость;ост_стоимость;время_эксплуатации;период)
														//$this->OutPPEAverageUsefulLife();
														return ($this->OutPPENetPPandE() - 0) * ($this->OutPPEAverageUsefulLife() - $this->InPPEFiscalPeriod + 1) * 2 / ($this->OutPPEAverageUsefulLife() * ($this->OutPPEAverageUsefulLife() + 1));
													}

															private function OutPPENetPPandE() {
																//=E314-E315-E316
																return $this->InWCGrossPPandEBOP - $this->InWCNonDepreciablePPandEBOP - $this->OutPPEAccumulatedDepreciation();
															}
															//reusable
															private function OutPPEAverageUsefulLife() {
																//ЕСЛИ(D319;D319;-ОКРУГЛ((E314-E315)/E308;0))
																if(isset($this->OutPPEAverageUsefulLife)) return $this->OutPPEAverageUsefulLife;
																if(is_null($this->InPPEAverageUsefulLifeOverride)) {
																	$this->OutPPEAverageUsefulLife = - round(($this->InWCGrossPPandEBOP - $this->InWCNonDepreciablePPandEBOP) / $this->OutPPEDepreciation());
																}
																else {
																	$this->OutPPEAverageUsefulLife = $this->InPPEAverageUsefulLifeOverride;
																}
																//var_dump($this->OutPPEAverageUsefulLife); exit(0);
																return $this->OutPPEAverageUsefulLife;
															}

													// this function returns array of values
													private function OutPPEDepreciationFromCapexPurchased() {
														$result = array();
														foreach(range(1,$this->InPPEFiscalPeriod) as $year) {
															if($year == $this->InPPEFiscalPeriod) $result[] = $this->InPPEMidYearAdjustment * $this->InWCCapitalExpenditures / $this->OutPPEAverageUsefulLife();
															else $result[] = $this->InWCCapitalExpenditures / $this->OutPPEAverageUsefulLife();
														}
														return $result;
													}




	private function OutPPEAccumulatedDepreciation() {
		//=E314-E295
		return $this->InWCGrossPPandEBOP - $this->InOBPropertyPlantAndEquipment;
	}
	private function OutPPEDepreciation() {
		//-(E175+E287)
		return -( $this->InPLHistoryDepreciationAndAmortization + $this->InIAAmortization);
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
		return $this->OutCFCashFromOperatingActivities() + $this->OutCFCashFromInvestingActivities() + $this->InDEBTAdditionalBorrowingOrPayDown + $this->InPLOtherComprehensiveIncomeOrLoss;
	}

	private function OutRCExcessCashAtBOP() {
		return   $this->InOBCashAndEquivalentsSTandLTMarketSecurities - $this->InDEBTRevolverMinimumCashDesired;
	}





	public function OutISBasicSharesOutstanding() {
		//СРЗНАЧ(F438;F441)
		return ($this->InISBasicSharesOutstanding + $this->OutSOEndOfPeriod() ) / 2;
	}

	private function OutSOEndOfPeriod() {
		//СУММ(F438:F440)
		return $this->InISBasicSharesOutstanding + $this->OutSONewSharesIssued() + $this->OutSOSharesRepurchased();
	}

	private function OutSONewSharesIssued() {
		//F376/F445
		return $this->InCSNewShareIssuance / $this->OutSOAverageSharePrice();
	}

	private function OutSOSharesRepurchased() {
		//F385/F445
		return $this->InCSStockRepurchases / $this->OutSOAverageSharePrice();
	}

	private function OutSOAverageSharePrice() {
		//E445*(1+F444)
		if(isset($this->OutSOAverageSharePrice)) return $this->OutSOAverageSharePrice;
		$this->OutSOAverageSharePrice = $this->InOBMarketSharePrice * (1 + $this->OutSOChangeInEPSYearOverYear());
		return $this->OutSOAverageSharePrice;
	}
	//reusable
	private function OutSOChangeInEPSYearOverYear() {
		//F443/E443-1
		if(isset($this->OutSOChangeInEPSYearOverYear)) return $this->OutSOChangeInEPSYearOverYear;
		$this->OutSOChangeInEPSYearOverYear = $this->OutSOConsensusEPS() / ($this->OutISDilutedEPS() - 1);
		return $this->OutSOChangeInEPSYearOverYear;
	}

	private function OutSOConsensusEPS() {
		//E443*(1+F444)
		return $this->OutISDilutedEPS() * (1 + $this->OutSOChangeInEPSYearOverYear());
	}
	//reusable
	private function OutISDilutedEPS() {
		//E158/E162
		if(isset($this->OutISDilutedEPS)) return $this->OutISDilutedEPS;
		$this->OutISDilutedEPS = $this->OutISNetIncome() / $this->InPLDilutedSharesOutstanding;
		return $this->OutISDilutedEPS;
	}

	private function OutISNetIncome() {
		return $this->OutISPretaxProfit() + $this->InPLTaxes;
	}
//commentik

}
