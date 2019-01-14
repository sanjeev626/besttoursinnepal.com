<?php
class menu extends mydb
{
	function menu()
	{
	
	}
	
	function getOrdering($parentId)
	{
		$sql = "SELECT * FROM tbl_category WHERE parent_id='$parentId' order by ordering desc LIMIT ";
		$result = $this->query($sql);
		$ras = $this->fetch_array($result);
		return $ras['ordering']+1;
	}
	
	function insert($urlcode,$menu,$parentId,$description,$imagename)
	{		
		$ordering = $this->getOrdering($parentId);
		$sql = "INSERT INTO tbl_category
					SET
						parent_id = '$parentId,',
						urlcode = '$urlcode',
						name = '$menu',
						description='$description',
						ordering = '$ordering',
						imagename = '$imagename'";
		$this->query($sql);
		$refid = $this->insert_id();
		return $refid; 
	}
	
	function updateImagename($cid,$imagename)
	{
		$sql = "UPDATE tbl_category
					SET
						imagename = '$imagename'
					WHERE id='$cid'
				";
		$this->query($sql);
	}
		
	function update($id,$urlcode,$menu,$parentId,$description,$imagename)
	{
		if(!empty($imagename))
		{
		$this->deleteCatImage($id);
		$sql = "UPDATE tbl_category
					SET
						urlcode = '$urlcode',
						name = '$menu',
						description='$description',
						imagename = '$imagename'
					WHERE id='$id'
					";
		}
		else
		{
		$sql = "UPDATE tbl_category
					SET
						urlcode = '$urlcode',
						name = '$menu',
						description='$description'
					WHERE id='$id'
					";
		}
		//echo $sql;
		$this->query($sql);
	}
	
	function updateOrdering($id,$ordering)
	{
		$sql = "UPDATE tbl_category
					SET
						ordering = '$ordering'
					WHERE id='$id'
					";		
		$this->query($sql);	
	}
	
	function getImagename($cid)
	{
		$sql = "SELECT imagename FROM tbl_category where id = '$cid'";
		$res = $this->query($sql);
		$ras = $this->fetch_array($res);
		return $ras['imagename'];
	}
	
	function getDesc($cid)
	{
		$sql = "SELECT description FROM tbl_category where id = '$cid'";
		$res = $this->query($sql);
		$ras = $this->fetch_array($res);
		return $ras['description'];
	}
	
	function getIdbyurlcode($urlcode)
	{
		$sql = "SELECT id FROM tbl_category where urlcode = '$urlcode'";
		$res = $this->query($sql);
		$ras = $this->fetch_array($res);
		return $ras['id'];
	}
	
	function deletemenu($id)
	{
		$this->deletemenuByid($id);
		$this->deleteProductBycid($id);
		$sql = "SELECT * FROM tbl_category WHERE parent_id=".$id;
		$res = $this->query($sql);
		while($ras=$this->fetch_array($res))
		{
			$this->deletemenuByid($ras['id']);
			$this->deleteProductBycid($ras['id']);
			$sql2 = "SELECT * FROM tbl_category WHERE parent_id=".$ras['id'];
			$res2 = $this->query($sql2);
			while($ras2=$this->fetch_array($res2))
			{
				$this->deletemenuByid($ras2['id']);
				$this->deleteProductBycid($ras2['id']);
				$sql3 = "SELECT * FROM tbl_category WHERE parent_id=".$ras2['id'];
				$res3 = $this->query($sql3);
				while($ras3=$this->fetch_array($res3))
				{
					$this->deletemenuByid($ras3['id']);
					$this->deleteProductBycid($ras3['id']);
					$sql4 = "SELECT * FROM tbl_category WHERE parent_id=".$ras3['id'];
					$res4 = $this->query($sql4);
					while($ras4=$this->fetch_array($res4))
					{
						$this->deletemenuByid($ras4['id']);
						$this->deleteProductBycid($ras4['id']);
						$sql5 = "SELECT * FROM tbl_category WHERE parent_id=".$ras4['id'];
						$res5 = $this->query($sql5);
						while($ras5=$this->fetch_array($res5))
						{
							$this->deletemenuByid($ras5['id']);
							$this->deleteProductBycid($ras5['id']);
							$sql6 = "SELECT * FROM tbl_category WHERE parent_id=".$ras5['id'];
							$res6 = $this->query($sql6);
							while($ras6=$this->fetch_array($res6))
							{
								$this->deletemenuByid($ras6['id']);
								$this->deleteProductBycid($ras6['id']);
								$sql7 = "SELECT * FROM tbl_category WHERE parent_id=".$ras6['id'];
								$res7 = $this->query($sql7);
								while($ras7=$this->fetch_array($res7))
								{
									$this->deletemenuByid($ras7['id']);
									$this->deleteProductBycid($ras7['id']);
								}
							}
						}
					}
				}
			}
		}
	}
	
	function deletemenuByid($id)
	{
		$this->deleteCatImage($cid);
		$sql = "DELETE FROM tbl_category WHERE id=$id";
		$this->query($sql);
	}
	
	function deleteCatImage($cid)
	{
		$imagename = $this->getImagename($cid);
		if(!empty($imagename))
		{
			$unlink1="menu/".$imagename;
			$unlink2="menu/thumb/".$imagename;
			@unlink($unlink1);
			@unlink($unlink2);
		}
	}	
	
	function deleteProductBycid($cid)
	{
		$ssql = "SELECT id FROM product WHERE cid=$cid";
		$rres = $this->query($ssql);
		while($rras = $this->fetch_array($rres))
		{
			$pid = $rras['id'];
			$this->deleteProduct($pid);
		}
	}	
	
	function deleteProduct($pid)
	{
		$this->deleteProductimages($pid);		
		$sql = "DELETE FROM product WHERE id = '$pid'";
		$this->query($sql);		
	}
	
	function deleteProductimages($pid)
	{
		//delete main image
		$imagename = $this->getproductImagename($pid);		
		$unlink1 = "product/".$imagename;
		$unlink2 = "product/thumb/".$imagename;
		@unlink($unlink1);
		@unlink($unlink2);
	}
	
	function getproductImagename($pid)
	{		
		$sql = "SELECT imagename FROM product WHERE id = '$pid'";					
		$res = $this->query($sql);
		$ras = $this->fetch_array($res);
		return $ras['imagename'];	
	}
	
	function getAllCategories()
	{		
		$sql = "SELECT * FROM tbl_category WHERE parent_id='0' order by ordering";
		$result = $this->query($sql);		
		return $result;
	}
	
	function getCategoriesByParentid($parent_id)
	{		
		$sql = "SELECT * FROM tbl_category where parent_id='$parent_id' order by ordering";
		$result = $this->query($sql);		
		return $result;
	}
	
	function get5CategoriesByParentid($parent_id)
	{		
		$sql = "SELECT * FROM tbl_category where parent_id='$parent_id' ORDER BY rand() LIMIT 5";
		$result = $this->query($sql);	return $result;

	}	

	function getmenuinfo($cid)
	{	
		$sql = "SELECT * FROM tbl_category where id='$cid'";
		$result = $this->query($sql);	$ras = $this->fetch_array($result);
		return $ras;
	}
	
	function getmenuname($cid)
	{	
		$sql = "SELECT * FROM tbl_category where id='$cid'";
		$result = $this->query($sql);	$ras = $this->fetch_array($result);
		return $ras['name'];;
	}	

	function getParentId($cid)
	{	
		$sql = "SELECT parent_id FROM tbl_category where id='$cid'";
		$result = $this->query($sql);	$ras = $this->fetch_array($result);
		return $ras['parent_id'];
	}
	
	function checkParentId($cid)
	{	
		$sql = "SELECT parent_id FROM tbl_category where parent_id='$cid'";
		$result = $this->query($sql);	$ras = $this->fetch_array($result);
		return $ras['id'];
	}
	
	function hassubcat($cid)
	{	
		$sql = "SELECT parent_id FROM tbl_category where parent_id='$cid'";
		$result = $this->query($sql);	$count = $this->count_rows($result);
		return $count;
	}
	
	function getBreadcrumb($id)
	{
		$parID = $this->getParentId($id);
		$parent_id[] = 1;
		$parent_id[] = 2;
		/*echo $parent_id[]=$this->getParentId($id);
		if($parID==0)
		{
			return $parent_id;
		}
		else
		{
			$this->getBreadcrumb($parID);
		}*/
		return $parent_id;
	}
}

$menuObj = new menu();
?>