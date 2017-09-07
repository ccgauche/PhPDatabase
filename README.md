# PhPDatabase
AFTER USE:
go in keys.php on your webserver and configure keys.

DataBase javaAPI:

<code type="java"> 
     DataBase db = new DataBase("http://localhost");
		 db.getKeyTerminal().addKey("YourAPIkeyforPUTdata","all",KeyType.PUT);
		 db.getKeyTerminal().addKey("YourAPIkeyforGETdata","all",KeyType.GET);
		 db.getKeyTerminal().addKey("YourAPIkeyforEXISTSdata","all",KeyType.EXISTS);
		 Sheet sh = db.getSheet("stats");
		 System.out.println(sh.exists("thejavaisthebestlanguage"));
		 sh.put("thejavaisthebestlanguage","yes");
		 System.out.println(sh.get("thejavaisthebestlanguage"));
		 sh.put("thejavaisthebestlanguage","no");
		 System.out.println(sh.get("thejavaisthebestlanguage"));
		 System.out.println(sh.exists("thejavaisthebestlanguage"));
		 ServerManager sv = db.getManager("ThePassWordOFadminAccount");
		 sv.addKey(KeyType.GET, "all", "aNewKeyForGet");
		 sv.addKey(KeyType.GET, "stats", "aNewKeyForGetOnlyInSheetStats");
</code>

Your can use the GET request system
https://www.dropbox.com/s/hzuy379lf1k1frz/Saphir.zip?dl=0
