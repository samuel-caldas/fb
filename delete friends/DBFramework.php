<?php
//conectar
function conect($servidor,$usuario,$pass,$database){return($c=mysql_connect($servidor,$usuario,$pass))?mysql_select_db($database,$c):false;}

//inserir
function insert($tab,$wr,$val){return mysql_query("INSERT INTO $tab ".($wr?"($wr)":"")." VALUES ($val)");}

//delete
function del($tab,$wr){return mysql_query("DELETE FROM $tab WHERE $wr");}

//Atualisa
function update($tabela,$val,$wr){return mysql_query("UPDATE $tabela SET $val WHERE $wr");}

//seleciona
function select($_,$tab,$wr,$order){
	if (mysql_num_rows($sql=MYSQL_QUERY("SELECT * FROM $tab".($wr?" WHERE $wr":"").($oder?" ORDER BY $order":"")))){
		$j=0;
		while($line=mysql_fetch_row($sql)){
			$result[$j]=$line;
			$j++;
		};
		return $result;
	}else{return false;};
};
function sel($tab,$wr,$order){return(count($saida=select("",$tab,$wr,$order))<2)?$saida[0]:$saida;}

//verifica
function exists($tab,$query){return(@mysql_num_rows(mysql_query("SELECT * FROM  $tab WHERE $query"))>0)?true:false;}

#Conectar#
#em ordem (servidor,usuario,senha e banco de dados);
conect('localhost','root','','fb_friends');

?>