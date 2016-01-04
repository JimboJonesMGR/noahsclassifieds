<?php

class CacheManager {

	var $timeFrame;
	var $key;
	var $fileName;
	var $incFileName;

	function CacheManager (&$base) 
    {        
        global $gorumroll, $language, $theme, $gorumrecognised, $gorumjavascript_cache, $gorumcategory;
        
        list($this->timeFrame, $categorySpecific) = $base->getCacheTimeFrameAndCategorySpecificity();
		if( $this->timeFrame )
        {
            $this->key = "$gorumroll->list-$gorumroll->method-$gorumroll->rollid-";
            $details = "language: $language, theme: $theme, authentication: ";
            hasAdminRights($isAdm);
            if( $isAdm ) $details.="admin, ";
            elseif( $gorumrecognised ) $details.="loggedin, ";
            else $details.="loggedout, ";
            $s = new Sorting($base);
            $details.=" sorting: " . $s->getSortSql(); 
            $classVars = $gorumroll->getClassVars();
            if( !empty($classVars["off"]) ) 
            {
                $details.=" offset: $classVars[off]";
            }
            if( $categorySpecific ) $details.=" category: $gorumcategory";
            //FP::log($details, "Details");
            $this->key.=substr(md5($details), 0, 16);
            $this->fileName = CACHE_DIR . "/" . $this->key . '.html';
            $this->incFileName = CACHE_DIR . "/" . $this->key . '.inc';
            if( $this->checkCache() )
            {
                $inc = file_get_contents($this->incFileName);
                $gorumjavascript_cache = unserialize($inc);
                //FP::log($this, "Loading include cache");                
                JavaScript::mergeCache($gorumjavascript_cache);
            }
            else
            {
                // Inicializaljuk az inklud kesst:
                $gorumjavascript_cache = new JavaScript;
                //FP::log($gorumjavascript_cache, "IncCache ujainit");
            }
        }
	}

	/**
	* Checks whether caching has been requested at all
	*
	* @return bool
	*/
	function isCacheActive() 
    {
        return $this->timeFrame;
	}

	/**
	* Checks if cache contains file no older than timeframe
	*
	* @return bool
	*/
	function checkCache() 
    {
        if( !$this->isCacheActive() ) 
        {
            //FP::log("checkCache: inactive");
            return FALSE;
        }
		if ( file_exists($this->fileName) && file_exists($this->incFileName) ) 
        {
            //FP::log("checkCache: inactive");
            $ret = (time() - filemtime ($this->fileName) < $this->timeFrame*60 );
            if( $ret ) ;//FP::log("checkCache: active");
            else ;//FP::log("checkCache: lejart");
            return $ret;
        }        
        //FP::log("checkCache: cache file doesn't exist: ".(!file_exists($this->fileName) ? $this->fileName : $this->incFileName));
		return FALSE;
	}

	/**
	* returns the content of the cache
	*
	* @return string
	*/
	function readCache() 
    {
        if( $this->checkCache() ) return $this->retrieveData();
	}

	/**
	* outputs the content of the cache
	*
	* @return string
	*/
    function passThroughCache()
    {
        //FP::log($this, "Reading cache:");
		if( $this->checkCache() )
		{
			if( !@readfile($this->fileName) )
			{
				if( ($ret=file_get_contents($this->fileName))!==FALSE ) echo $ret;
			}
		}
    }
    
	/**
	* Read the content of the file
	*
	* @param string filename
	* @return string
	*/
	function retrieveData () 
    {
		$fp      = fopen ($this->fileName, 'r');
		$content = fread ($fp, filesize ($this->fileName));
		fclose ($fp);
		return $content;
	}

	/**
	* Store content in the file
	*
	* @return string
	*/
	function saveCache ($content) 
    {        
        if( !$this->isCacheActive() ) return;
        //FP::log($this, "Saving cache:");
        $f = fopen ($this->fileName, 'w+');
        fwrite ($f, $content);
        fclose ($f);
        
        return $this->fileName;
	}

	function saveIncludeCache() 
    {
        global $gorumjavascript_cache;
        
        if( !$this->isCacheActive() ) return;
        //FP::log($this, "Saving include cache:");
        
        // az include cache tartalmat is kiirjuk a .inc file-ba:
        $f = fopen ($this->incFileName, 'w+');
        fwrite ($f, serialize($gorumjavascript_cache));
        fclose ($f);
        $gorumjavascript_cache = 0; // lenullazzuk az incude cache-t:
        
        return $this->incFileName;
	}

	function resetCache($cidOrCustomListId=0, $performReset=FALSE, $categoryId=TRUE) 
    {
        static $resetForCategories = array();
        
        if( !file_exists(CACHE_DIR) ) return;
        // a program vegrehajtasa soran a $resetForCategories-be gyujtogetjuk azokat a category ID-ket, amikre a 
        // cache-t a program vegen resetelni kell. Azert csinaljuk igy, hogy a tenyleges resetelest csak egyszer kelljen vegrehajtani
        if( $categoryId ) $resetForCategories[]=$cidOrCustomListId;
        if( ($performReset && $count=count($resetForCategories)) || !$categoryId )
        {
            // vagy cid alapjan torlunk file-okat, vagy custom list ID alapjan:
            if( $categoryId )
            {
                $cidCond = $count==1 ? "cid='$resetForCategories[0]'" : "FIND_IN_SET(cid, '".implode(",", $resetForCategories)."')!=0";
                $query="SELECT id FROM @search WHERE $cidCond AND cache!=0";
                loadObjectsSql($lists = new CustomList, $query, $lists);
            }
            else
            {
                $lists = array(new CustomList);
                $lists[0]->id = $cidOrCustomListId;
            }
            if( count($lists) && ($d = dir(CACHE_DIR)) )
            {
                $files = array();
                while( false !== ($entry = $d->read()) ) 
                {
                   if( strstr($entry, ".html") || strstr($entry, ".inc") ) $files[]=$entry;
                }        
                foreach( $lists as $l )
                {
                    foreach( $files as $f ) 
                    {
                        if( strstr($f, "item_search-showhtmllist-$l->id-") ) 
                        {
                            //FP::log("Deleting $f");
                            @unlink(CACHE_DIR . "/" . $f);
                        }
                    }
                }
            }
        }
    }
    
	function resetAllCache() 
    {
        if( !($d = dir(CACHE_DIR)) ) return;  // directory permission problem
        while( false !== ($entry = $d->read()) ) 
        {
           if( strstr($entry, ".html") || strstr($entry, ".inc") ) 
           {
                //FP::log("Deleting $entry");
                @unlink(CACHE_DIR . "/" . $entry);
           }
        }        
    }
}
?>