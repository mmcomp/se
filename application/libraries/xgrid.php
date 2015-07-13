<?php
class xgrid
{
	public $page_addr='';
	public $row = array();
	public $column = array();
	public $tables = array();
	public $name = array();
	public $pageAllRows = array(); 
	public $pageRows = array();
	public $pageCount = array();
	public $pageNumber =array(); 
	public $out = array();
	public $done = FALSE;
	public $row_css =array();
	public $cell_css= array();
	public $css = array();
	public $tableProperty = array();
	public $clist = array();
	public $cfunction =array();
	public $arg = '';
	//-----------------------
	public $canAdd =array();//FALSE;
	public $canEdit = array();//FALSE;
	public $canDelete =array();// FALSE;
	public $contentDiv =array();// 'main_div';
	public $targetFile =array();
	public $cssClass =array();// 'ajaxgrid';
	public $start = array();//TRUE;
	public $addColCount = array();//3;
	public $addFunction = array();//null
	public $editFunction = array();//null
	public $deleteFunction = array();//null
	public $whereClause = array();//''
	public $buttonTitles = array();//array('delete'=>'حذف','add'=>'ثبت','next'=>'بعد','pre'=>'قبل'); 
	public $eRequest = array();//array();
	public $echoQuery = FALSE;
	public $alert = FALSE;
	public $afterCreateFunction = array();
	public $disableRowColor = array();
	public $scrollDown = array();
	public $xls = array();
	public function __construct($inp= array(),$addr='')
	{
		$mysql = new mysql_class;
		$css = 'ajaxgrid_mainDiv';
		$tableProperty = "class='ajaxgrid_mainTable'";
		if(count($inp)!=0 && is_array($inp))
		{
			
			$gtmp =array();
			foreach($inp as $gname=>$det)
			{
				$gtmp[$gname]['gname'] = $gname;
				$gtmp[$gname]['table'] = $det['table'];
				$gtmp[$gname]['contentDiv'] = $det['div'];
				$this->contentDiv[$gname] = $det['div'];
				$gtmp[$gname]['canAdd'] = FALSE;
				$this->canAdd[$gname] = FALSE;
				$gtmp[$gname]['canEdit'] = FALSE;
				$this->canEdit[$gname] = FALSE;
				$gtmp[$gname]['canDelete'] = FALSE;
				$this->canDelete[$gname] = FALSE;
				$gtmp[$gname]['targetFile'] =($addr==''?$this->getAddr():$addr);
				$this->targetFile[$gname] = $gtmp[$gname]['targetFile'];
				$gtmp[$gname]['cssClass'] ='ajaxgrid' ;
				$this->cssClass[$gname] = 'ajaxgrid';
				$gtmp[$gname]['start'] =TRUE ;	
				$this->start[$gname] = TRUE;
				$gtmp[$gname]['addColCount'] =3 ;
				$this->addColCount[$gname] = 3;
				$gtmp[$gname]['tableProperty'] = "class='ajaxgrid_mainTable'";
				$this->tableProperty[$gname] ="class='ajaxgrid_mainTable'";
				$this->xls[$gname] = TRUE;
				$gtmp[$gname]['xls'] = TRUE;
				$gtmp[$gname]['css'] = "darkDiv";
				$gtmp[$gname]['eRequest'] = array();
				$gtmp[$gname]['pageNumber'] = 1;
				$this->tables[$gname] = $det['table'];
				$this->pageRows[$gname] = 10;
				$this->whereClause[$gname] = '';
				$this->pageNumber[$gname] = 1;
				$this->eRequest[$gname] = array();
				$this->scrollDown[$gname] = FALSE;
				$this->afterCreateFunction[$gname] = '';
				$this->disableRowColor[$gname] = FALSE;
				$this->buttonTitles[$gname] = array('delete'=>'حذف','add'=>'ثبت','next'=>'بعد','pre'=>'قبل'); 
				$q = null;
				$mysql->enableCache = FALSE;
				$mysql->oldSql = TRUE;
				$mysql->directQuery('select * from `'.$this->tables[$gname].'` where 1=0 ',$q);
				//while($r = $mysql->fetch_field($q))
                                $hamed_tmp = $mysql->fetch_field($this->tables[$gname]);
                                foreach($hamed_tmp as $r)
				{
					$cTmp['name']=(isset($mysql->translate_field_1[$r->name]) && $this->tables[$gname]=='user_etebar')?$mysql->translate_field_1[$r->name]:$r->name;
					$cTmp['fieldname']= (isset($mysql->translate_field_1[$r->name]) && $this->tables[$gname]=='user_etebar')?$mysql->translate_field_1[$r->name]:$r->name;
					$cTmp['css']='';
					$cTmp['typ']= $r->type;
					$this->column[$gname][] = $cTmp;
				}
				$this->pageAllRows[$gname] = $this->getTableRowCount($det['table'],$_REQUEST);
				$this->pageCount[$gname] = xgrid::getPageCount($this->tables[$gname],$this->pageRows[$gname],$_REQUEST);
				$gtmp[$gname]['pageCount']= $this->pageCount[$gname] ;
				$this->css[$gname] = $gtmp[$gname]['cssClass']; 
				$this->tableProperty[$gname] = $gtmp[$gname]['tableProperty'];
				$this->addFunction[$gname] = null;
				$this->editFunction[$gname] = null;
				$this->deleteFunction[$gname] = null;
			}
			$this->arg = toJSON($gtmp);//toJSON($gtmp);
		}
	}
	public function arrayToObject($array)
	{
		$out = $array;
		if(is_array($array))
		{
			$out = null;
			$out = array();
			foreach($array as $key=>$value)
				$out[]=array('id'=>$key,'val'=>$value);
		}
		return($out);
	}
	public function getTableRowCount($table,$req=array())
	{
		$mysql = new mysql_class;
		$werc = '';
		if(isset($req['table']))
		{
			$gname = $req['table'];
        	        $whereClause = (isset($this->whereClause[$gname]))?$this->whereClause[$gname]:'';
                	$werc = (isset($req['werc']))?$req['werc']:'';
	                $werc = str_replace('|','%',$werc);
        	        $werc = str_replace('where',' ',$werc);
			$werc = str_replace("\\'","'",$werc);
                	if($werc != '' || $whereClause != '')
	 	               $werc = ' where '.$werc.' '.(($werc != '' && $whereClause != '')?'and '.$whereClause:$whereClause);
		}
		$out = FALSE;
		$mysql->ex_sql('select count(`id`) as `co` from `'.$table.'` '.$werc,$q);
		if(isset($q[0]))
			$out = (int)$q[0]['co'];
		return $out;
	}
	public function getPageCount($table,$pageRows,$req=array())
	{
		$pageAllRows = xgrid::getTableRowCount($table,$req);
		$extraRows = 0;
		$out = 0;
		if($pageRows!=0)
		{
			$extraRows = $pageAllRows % $pageRows;
			$out = (($pageAllRows - $extraRows)/$pageRows);
		}
		if((int)$extraRows!=0)
			$out++;
		return ($out);
	}
	public function getOut($req)
	{
		$mysql = new mysql_class;
		$gname = '';
		$gtmp =array();
		foreach($this->tables as $gname=>$ttable)
		{
			$gtmp[$gname]['gname'] = $gname;
			$gtmp[$gname]['table'] = $ttable;
			$gtmp[$gname]['contentDiv'] = $this->contentDiv[$gname];
			$gtmp[$gname]['canAdd'] = $this->canAdd[$gname];
			$gtmp[$gname]['canEdit'] = $this->canEdit[$gname];
			$gtmp[$gname]['canDelete'] = $this->canDelete[$gname];
			$gtmp[$gname]['targetFile'] = $this->targetFile[$gname];
			$gtmp[$gname]['cssClass'] =$this->cssClass[$gname];
			$gtmp[$gname]['start'] =$this->start[$gname];	
			$gtmp[$gname]['addColCount'] =$this->addColCount[$gname];
			$gtmp[$gname]['tableProperty'] = $this->tableProperty[$gname];
			$gtmp[$gname]['css'] =  $this->css[$gname];
			$this->pageAllRows[$gname] = $this->getTableRowCount($ttable,$req);
			$this->pageCount[$gname] = $this->getPageCount($ttable,$this->pageRows[$gname],$req);
			$gtmp[$gname]['pageCount']= $this->pageCount[$gname];
			$gtmp[$gname]['pageNumber']= $this->pageNumber[$gname];
			$gtmp[$gname]['eRequest'] = $this->eRequest[$gname];
			$gtmp[$gname]['alert'] = $this->alert ;
			$gtmp[$gname]['disableRowColor'] = $this->disableRowColor[$gname];
		}
		if(isset($req['command']) && isset($req['table']) && $req['command']!='csv')
		{
			$gname = trim($req['table']);
			$table = $this->tables[$gname];
			$this->done = TRUE;
			$fn = '';
			if(isset($req['field']))
				$fn = (isset($this->column[$gname][$this->fieldToId($gname,$req['field'])]['cfunction'][1]))?$this->column[$gname][$this->fieldToId($gname,$req['field'])]['cfunction'][1]:'';
			$this->out[$gname] = 'error';
			switch ($req['command'])
			{
				case 'update':
					if(isset($req['field']) && isset($req['value']) && isset($req['id']))
						$this->out[$gname] = $this->update($table,$req['id'],$req['field'],$req['value'],$fn,$gname);
					else
						$this->out[$gname] = 'failed';
					break;
				case 'delete':
					if(isset($req['ids']) && $req['ids']!='')
						$this->out[$gname] = $this->delete($table,$req['ids'],$gname);
					else
						$this->out[$gname] = 'failed';
					break;
				case 'insert':
					$this->out[$gname] = $this->insert($gname,$table,$req);
					break;
/*
                                case 'csv':
                                        $all = $req['all']=='1'?TRUE:FALSE;
                                        if(!$all)
                                        {

                                                //$csvTmp = fromJSON($req['data']);
                                                $csvFileName = '../csv/'.$req['fname'];
						
                                                $csvF = fopen($csvFileName,"w+");
                                                foreach($csvTmp as $line)
                                                        fputcsv($csvF,$line);
                                                fclose($csvF);
                                                $this->out[$gname] = '../csv/'.$req['fname'];
						
                                        }
                                        else
                                                $this->out[$gname] = '';
					break;
*/
			}
			$this->pageCount[$gname] = $this->getPageCount($table,$this->pageRows[$gname],$req);
			$this->out[$gname] = ($this->out[$gname].','.$this->pageCount[$gname].','.$gname);
		}
		else if((isset($req['pageNumber']) && isset($req['table'])))// || (isset($req['command']) && $req['command']=='csv'))
		{
			$gname = trim($req['table']);
			$isCsv = (isset($req['command']) && $req['command']=='csv');
			$whereClause = $this->whereClause[$gname];
			$werc = (isset($req['werc']))?$req['werc']:'';
			$werc = str_replace('|','%',$werc);
			$werc = str_replace('where',' ',$werc);
			$werc = str_replace("\\'","'",$werc);
			if($werc != '' || $whereClause != '')
				$werc = ' where '.$werc.' '.(($werc != '' && $whereClause != '')?'and '.$whereClause:$whereClause);
			$ttable = $this->tables[$gname];
			$this->pageCount[$gname] = $this->getPageCount($ttable,$this->pageRows[$gname],$req);
			$this->done = TRUE;
			$gname= trim($req['table']);
			$table = $this->tables[$gname];
			if(isset($req['pageNumber']))
				$this->pageNumber[$gname] = (int)$req['pageNumber'];
			$sort = '';
			$sort_array = array();
			foreach($req as $rk => $rv)
			{
				$sort_tmp = explode("-",$rk);
				if(count($sort_tmp) == 2 && $sort_tmp[0] == 'sort')
					$sort_array[] = $rv;
			}
			if(count($sort_array) > 0)
				$sort = ((strpos($werc,'order')===FALSE)?" order by `":',`').implode('` desc,`',$sort_array)."` desc";
			if($this->echoQuery)
				echo 'select * from `'.$table.'` '.$werc.' '.$sort.' limit '.(int)(($this->pageNumber[$gname]-1)*$this->pageRows[$gname]).','.(int)$this->pageRows[$gname]."<br/>\n";
			$mysql->ex_sql('select * from `'.$table.'` '.$werc.' '.$sort.' limit '.(int)(($this->pageNumber[$gname]-1)*$this->pageRows[$gname]).','.(int)$this->pageRows[$gname],$q);
			$i=0;
			$row = array();
			$csvHead = "";
			$loadHead = TRUE;
			$csvBigBody = "";
			foreach($q as $rr)
			{
				$cell = array();
				$csvBody = '';
				foreach($this->column[$gname] as $k=>$field)
				{
					$fn = isset($field['cfunction'][0])?$field['cfunction'][0]:'';
					//$tValue = ($fn!='')?$fn(htmlentities($rr[$field['fieldname']])):htmlentities($rr[$field['fieldname']]);
					$tValue = ($fn!='')?$fn($rr[$field['fieldname']]):$rr[$field['fieldname']];
					if($loadHead)
						$csvHead .= (($csvHead!='')?",":'').$field['fieldname'];
					//$tmpVal = str_replace("\n",'',((!isset($this->column[$gname][$k]['clist']))?$tValue:$this->column[$gname][$k]['clist'][$rr[$field['fieldname']]])); 

					//$tmpVal = str_replace(',','',$tmpVal);
					//$tmpVal = mb_convert_encoding($tmpVal,'UTF-8');//,"Windows-1256");
					//$tmpVal = mb_convert_encoding($tmpVal, 'UTF-16LE', 'UTF-8');
					//$tmpVal = mb_convert_encoding($tmpVal,"Windows-1252");
					//if($k > 0)
					//	$csvBody .= (($csvBody!='')?",":'').strip_tags($tmpVal);
					$cell[] = array('value'=>$tValue,'css'=>$this->loadCellCss($rr['id'],$field['fieldname']),'typ'=>$field['typ']);
					if(in_array($field['fieldname'],$sort_array))
						$this->column[$gname][$k]['sort'] = 'done';

				}
				$loadHead = FALSE;
				$csvBigBody .= "$csvBody\n";
				$row[] = array('cell'=>$cell,'css'=>$this->loadRowCss($rr['id'],$gname));
			}
			$rowCount = xgrid::getTableRowCount($ttable,$req);
			foreach($this->column[$gname] as $indx=>$column)
			{
				if(isset($column['clist']))
					$this->column[$gname][$indx]['clist'] = $this->arrayToObject($column['clist']);
				if(isset($column['searchDetails']))
					$this->column[$gname][$indx]['searchDetails'] = $this->arrayToObject($column['searchDetails']);
			}
			$grid = array('column'=>$this->column[$gname],'rows'=>$row,'cssClass'=>$this->css[$gname],'tableProperty'=>$this->tableProperty[$gname],'css'=>'','buttonTitles'=>$this->buttonTitles[$gname],'eRequest'=>$this->eRequest[$gname],'pageCount'=>$this->pageCount[$gname],'alert'=>$this->alert,'scrollDown'=>$this->scrollDown[$gname],'xls'=>$this->xls[$gname],'pageRows'=>$this->pageRows[$gname],'rowCount'=>$rowCount);
			if(!$isCsv)
			{
				$affn = $this->afterCreateFunction[$gname];
				if($affn != '')
					$fgrid = $affn($grid);
				else
					$fgrid = $grid;
				$this->out[$gname] = toJSON($fgrid);
			}
			else
			{
				$csvOut = "";
				header('Content-Type: text/csv; charset=utf8');
				header('Content-disposition: attachment;filename='.$req['table'].'.csv');
				header('Content-type: application/x-msdownload');
				$this->out[$gname] =  /*chr(255).chr(254).*/$csvBigBody;//.mb_convert_encoding($csvHead."\n".$csvBigBody, 'UTF-16LE', 'UTF-8');
			}
		}
		$gtmp[$gname]['pageCount']= $this->pageCount[$gname] ;
		$this->arg = toJSON($gtmp);
		return ((isset($this->out[$gname]))?$this->out[$gname]:'');
	}
	public function loadCellCss($id,$fieldname)
	{
		$out = '';
		if(count($this->cell_css>0))
			foreach($this->cell_css as $row=>$value)
				if($row==$id)
					foreach($value as $field=>$css)
						if($fieldname==$field)
							$out = $css;
		return $out;
	}
	public function loadRowCss($id,$gname)
	{
		$out = '';
		if(isset($this->row_css[$gname]) && count($this->row_css[$gname])>0)
			foreach($this->row_css[$gname] as $rowsdat)
			{
				$rows = $rowsdat['rows'];
				$css = $rowsdat['css'];
				if(in_array($id,$rows))
					$out=$css;
			}
		return $out;
	}
	public function update($table,$id,$field,$val,$fn,$gname)
	{
		$out = 'failed';
//		$val = str_replace('*$','#',$val);
		if($this->editFunction[$gname] != null)
		{
			$ef = $this->editFunction[$gname];
			$ef_out = $ef($table,$id,$field,$val,$fn,$gname);
			$out = ($ef_out===TRUE)?'true':'failed'.$ef_out;
		}
		else
		{
			$val = ($fn!='')?$fn($val):$val;
			$mysql = new mysql_class;
			if($this->echoQuery)
				echo "update `$table` set `$field`='$val' where `id`= $id";
			$out = ($mysql->ex_sqlx("update `$table` set `$field`='$val' where `id`= $id")=='ok')?'true':'failed';
		}
		return($out);
	}
	public function delete($table,$id,$gname)
	{
		$out = 'failed';
		$mysql = new mysql_class;
		if($this->deleteFunction[$gname] == null)
		{
			if($this->echoQuery)
				echo "delete from `$table` where `id` in ($id) ";
			$out = ($mysql->ex_sqlx("delete from `$table` where `id` in ($id) ")=='ok')?'true':'failed';
		}
		else
		{
			$df = $this->deleteFunction[$gname];
			$df_out = $df($table,$id,$gname);
                        $out = ($df_out===TRUE)?'true':'failed'.$df_out;
		}
		return($out);
	}
	public function insert($gname,$table,$req)
	{
		$out = -1;
		$mysql = new mysql_class;
		$fields=array();
		foreach($req as $key=>$value)
		{
			$tmp = explode('-',$key) ;
			if($tmp[0]==$gname && count($tmp)==2)
				$fields[$tmp[1]] = $value;
		}
		if(count($fields)>0)
		{
			$out = '';
			if($this->addFunction[$gname] != null)
			{
				$af = $this->addFunction[$gname];
				$out = $af($gname,$table,$fields,$this->column[$gname]);
			}
			else
			{
				$fi = "(";
				$valu="(";
				foreach ($fields as $field => $value)
				{
					$fn = (isset($this->column[$gname][$this->fieldToId($gname,$field)]['cfunction'][1]))?$this->column[$gname][$this->fieldToId($gname,$field)]['cfunction'][1]:'';
					$value = ($fn!='')?$fn($value):$value;
					$fi.="`$field`,";
					$valu .="'$value',";
				}
				$fi=substr($fi,0,-1);
				$valu=substr($valu,0,-1);
				$fi.=")";
				$valu.=")";
				$query = "insert into `$table` $fi values $valu";
				if($this->echoQuery)
					echo($query);
				$ln = $mysql->ex_sqlx($query,FALSE);
//				$ln = mysql_class::ex_sqlx($query,FALSE);
				$out = (string)$mysql->insert_id($ln);
				//$out = (string)mysql_insert_id($ln);
				//mysql_close($ln);
			}
		}
		return $out;
	}
	public function getAddr()
	{
		$tmp = $_SERVER['PHP_SELF'];
		$tmp = explode('/',$tmp);
		$out = $tmp[count($tmp)-1];
		return $out;
	}
	public function loadList($table,$val,$text,$where)
	{
		$out = array();
		$mysql = new mysql_class;
		$mysql->ex_sql("select `$val`,`$text` from `$table` where $where ",$q);
		while($r = $mysql->fetch_array($q))
			$out[$r[$val]] = $r[$text];
		return $out;
	}
	public function fieldToId($gname,$field)
	{
		$out = '';
		foreach($this->column[$gname] as $i=>$fields)
			if($fields['fieldname']==$field)
				$out = $i;
		return $out;
	}
}
?>
