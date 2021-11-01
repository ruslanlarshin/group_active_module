<?
CModule::IncludeModule("iblock");

if($_REQUEST['clear']!='yes'){
	$time=0;// время жизни кеша в секундах -для отключения и тестирования-0
}else{
	if($arParams['TIME']){//время кеша из параметров
		$time=$arParams['TIME'];
	}else{$time=360000;}
}

if($this->StartResultCache($time, array($arOption))){ //кеш берется по значению $arParams и $arOption-если таковых ранее не загружалось-начнется загрузка компонента
	if($arError){ //если шаблон ошибочен-то кеш не запишется
		$this->AbortResultCache();
		ShowError(GetMessage("IBLOCK_MODULE_NOT_INSTALLED"));
		return;
	}
	$arResult=array();
	$arResult['PARAM']=$arParams;

	$rsGroups = CGroup::GetList(($by="c_sort"), ($order="asc"), array('ACTIVE'=>"Y"),"Y"); // выбираем группы
		while ($aItem = $rsGroups->Fetch()) {
				$filter_group = Array
				(		
					"ACTIVE"              => "Y",
					"GROUPS_ID"           => array($aItem['REFERENCE_ID'])
				);
				$rsUsers = CUser::GetList(($by="personal_country"), ($order="desc"), $filter_group); 
				$arResult[]=array('GROUP'=>$aItem["NAME"],'COUNT'=>$rsUsers->SelectedRowsCount());
			} 
	
	$this->IncludeComponentTemplate();
	//echo 'Загрузился весь шаблон и сохранился в кеш';
	if($arError)
	{
		$this->AbortResultCache();
		ShowError("ERROR");
		@define("ERROR_404", "Y");
		if($arParams["SET_STATUS_404"]==="Y")
			CHTTP::SetStatus("404 Not Found");
	}
}else{
	//echo 'Шаблон взят и кеша!<BR>';// происходит тогда, когда загружен кеш-эффективно для проверки работы кеша и скорости без него!!
}
?>