<?php
/**
 * Priceless PHP
 * It's not free, it's priceless
 *
 * @author      MarQuis Knox <opensource@marquisknox.com>
 * @copyright   2015 MarQuis Knox
 * @link        http://marquisknox.com
 * @link        http://pricelessphp.com
 * @license     Affero General Public License v3
 *
 * @since  	    Wednesday, February 04, 2015, 16:25 GMT+1
 * @modified    $Date$ $Author$
 * @version     $Id$
 *
 * @category    Class
 * @package     Priceless PHP
*/

class Priceless
{
    /**
     * Make an embed responsive
     * 
     * @param   string  $string
     * @param   string  $targetWidth
     * @return  string
    */
    public function makeEmbedResponsive( $string, $targetWidth = '100%' )
    {
        $string = preg_replace(
            array( '/width="\d+"/i' ),
            array( sprintf( 'width="%s"', $targetWidth ) ),
            $string
        );
    
        return $string;
    }
    
    /**
     * Get the mime type based on 
     * the filename
     * 
     * @param   string  $file
     * @return  string
    */
    function getMimeTypeFromFile( $file )
    {
        $mimeTypes = array(
            '3gp'   => 'video/3gpp',        
            'avi'   => 'video/x-msvideo',
            'css'   => 'text/css',           
            'doc'   => 'application/msword',
            'docx'  => 'application/msword',
            'exe'   => 'application/octet-stream',
            'gif'   => 'image/gif',        
            'htm'   => 'text/html',
            'html'  => 'text/html',
            'jpeg'  => 'image/jpg',
            'jpg'   => 'image/jpg',                
            'js'    => 'application/javascript',
            'jsc'   => 'application/javascript',
            'mp3'   => 'audio/mpeg',
            'mpe'   => 'video/mpeg',                
            'mpeg'  => 'video/mpeg',
            'mpg'   => 'video/mpeg',
            'mov'   => 'video/quicktime',
            'php'   => 'text/html',                                   
            'pdf'   => 'application/pdf',
            'png'   => 'image/png',        
            'ppt'   => 'application/vnd.ms-powerpoint',
            'wav'   => 'audio/x-wav',
            'zip'   => 'application/zip',
            'xls'   => 'application/vnd.ms-excel',               
        );
    
        $extension = strtolower( end( explode('.', $file ) ) );
    
        return $mimeTypes[ $extension ];
    }   
    
    /**
     * Get the file extension 
     * based on the mime type
     *
     * @param   string  $mimeType
     * @return  string
    */
    function getFileExtensionFromMimeType( $mimeType ) 
    {
        $extensions = array(
            'image/bmp'     => 'bmp',
            'image/gif'     => 'gif',
            'image/jpg'     => 'jpg',
            'image/jpeg'    => 'jpeg',        
            'image/png'     => 'png',        
            'text/xml'      => 'xml',
        );
    
        return $extensions[ $mimeType ];
    } 
    
}
