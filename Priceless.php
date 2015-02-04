<?php
/**
 * Priceless PHP
 * It's not free, it's priceless
 *
 * @author      MarQuis Knox <opensource@marquisknox.com>
 * @copyright   2015 MarQuis Knox
 * @link        http://marquisknox.com
 * @license     Affero General Public License v3
 *
 * @since  	    Wednesday, February 04, 2015, 16:25 GMT+1
 * @modified    $Date: 2014-10-13 11:46:37 +0200 (Mon, 13 Oct 2014) $ $Author: dev@bizlogicdev.com $
 * @version     $Id: AdminController.php 109 2014-10-13 09:46:37Z dev@bizlogicdev.com $
 *
 * @category    Class
 * @package     Priceless PHP
*/

class Priceless
{
    public function makeEmbedResponsive( $string, $targetWidth = '100%' )
    {
        $string = preg_replace(
            array( '/width="\d+"/i' ),
            array( sprintf( 'width="%s"', $targetWidth ) ),
            $string
        );
    
        return $string;
    }
}
