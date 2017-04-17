<?php
//XAMPP
require_once( ini_get("include_path") . "spare/commands/default.php" );

class harber_CommandResolver {
    /*private static $base_cmd;
    private static $default_cmd;
*/

	private $cats = array("sundials","sculpture","water","about","corporate","forms","armillary","maps","bespoke","test","press","trails","error","indoor","approach","ethos","exterior");
        private $commands_include_path;
	
    function __construct() {
       $this -> commands_include_path = ini_get("include_path") . "spare/commands/";
    }

    function getCommand( harber_Request $request ) {
                $subtype = $request->getProperty( 'subtype' );
		$cat = $request->getProperty( 'cat' );
		$filepath; $classname;
		
								
		if ($cat) {
			if (!in_array($cat,$this -> cats)) {
				$request->addFeedback( "Non-existent cat: $cat, commandResolver.php line 26");
				return false;
			}
		}
                
		Util::Show($cat,"cat");
		//TODO may not need to check for special pages
		$newCats = array ("indoor","sundials","sculpture","water","corporate","approach","ethos");
		/*$specialCats = array ("about","news","videos","resources","forms","maps","test","any","press","special");
	  $specialSubtypes = array("top","davidH","craftsmanship","directions","directions_workshop"); //pages in special cats that are default type pages*/
	  /*$defaultSpecialSubtypes = array("mottoes","plinths","octagon_youtube","kernel_youtube","matrix_youtube","slatetorus_youtube","sorceress_youtube","fire_youtube","petal_youtube","video");
		$newsSpecialSubtypes = array("blagrave","time","installation");
		$pressSpecialSubtypes = array("special");*/
                //TODO may not need to distinguish between non subtype and with subtype. but will need to do something about sub and sub sub menus and think there is a design pattern
                
                
                if (!$cat) {
                        $filepath = $this -> commands_include_path . "home.php";
                        $classname = "command_default";
			
		} else {
			
			//if (in_array($subtype, $specialSubtypes)) {
			if ($subtype == "top") {
					$filepath =  $this -> commands_include_path . "new_top.php";
					$classname = "command_top";
//					Util::Show($filepath . " and " . $classname,"filepath and classname");
//					Util::Show($classname,"classname");
			} else {
                            if (in_array($cat, $newCats)) {
                              $filepath =  $this -> commands_include_path . "new_text.php";
                              $classname = "command_newtext";
                            }
			
                        }
                }
//                if (!$cat) {
//                        $filepath = $this -> commands_include_path . "home.php";
//                        $classname = "command_default";
//			
//		} else {
//			
//			if (in_array($cat, $specialCats) && !(in_array($subtype, $specialSubtypes))) {
//					$filepath =  $this -> commands_include_path . $cat . ".php";
//					$classname = "command_$cat";
////					Util::Show($filepath . " and " . $classname,"filepath and classname");
////					Util::Show($classname,"classname");
//			} else {
//							if (in_array($cat, $newCats)) {
//							  $filepath =  $this -> commands_include_path . "new_text.php";
//							  $classname = "command_newtext";
//							} else if  (!in_array($subtype, $defaultSpecialSubtypes)) {
//							  $filepath =  $this -> commands_include_path . "text.php";
//							  $classname = "command_text";
//                          } else if  (in_array($subtype, $newsSpecialSubtypes)) {
//                             $filepath =  $this -> commands_include_path . "news.php";
//                            $classname = "command_news";
//                          } else {
//                             $filepath =  $this -> commands_include_path . "about.php";
//                            $classname = "command_about";
//                          }
//			}
//			
//		}
		
		if ( file_exists( "$filepath" ) ) {
				//Util::Show($filepath, "filepath exits from commandresolver");
                    require_once( $filepath );
                 
                    if ( class_exists( $classname ) ) {
			//Util::Show($classname, "classname exists from commandresolver");
                        return new $classname();
                    } else {
                        $request->addFeedback( "classname $classname does not exist" );
			return false;
                    }
                } else {
                    $request->addFeedback( "filepath $filepath does not exist");
                    return false;
		}
		
        $request->addFeedback( "command '$cmd' not found" );
		return false;
    }
}

?>
