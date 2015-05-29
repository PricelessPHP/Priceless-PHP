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
    public function getMimeTypeFromFile( $file )
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
            'xls'   => 'application/vnd.ms-excel',             
            'zip'   => 'application/zip',
        );
    
        $extension = strtolower( end( explode( '.', $file ) ) );
    
        return $mimeTypes[ $extension ];
    }   
    
    /**
     * Get the file extension 
     * based on the mime type
     *
     * @param   string  $mimeType
     * @return  string
    */
    public function getFileExtensionFromMimeType( $mimeType ) 
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
 
    /**
     * Convert an integer to 
     * the corresponding month
     * 
     * @param   int     $integer
     * @return  mixed   boolean or string
    */
    public function integerToMonth( $integer )
    {
        $integer = (int)$integer;
        if( $integer == 0 ) {
            return false;    
        }
        
        return jdmonthname( gregoriantojd( $integer, 1, 1 ), CAL_MONTH_GREGORIAN_LONG );    
    } 
    
    /**
     * Remove traling slash 
     * from a string
     * 
     * @param   string  $string
     * @return  string
    */
    public function removeTrailingSlash( $string )
    {
        $string = rtrim( $string, '/' );
        return $string;    
    }   
    
    /**
     * Recursively delete a directory
     * 
     * @link    http://stackoverflow.com/a/3338133
     * @param   string  $dir
     * @param   boolean $deleteSelf
     * @return  mixed
    */
    public function recursive_rmdir( $dir, $deleteSelf = true ) 
    {
        if ( is_dir( $dir ) ) {
            $objects = scandir( $dir );
            foreach ( $objects AS $object ) {
                if ( ( $object != '.' ) AND ( $object != '..' ) ) {
                    if ( filetype( $dir.'/'.$object ) == 'dir' ) {
                        recursive_rmdir( $dir.'/'.$object );
                    } else {
                        unlink( $dir.'/'.$object );
                    }
                }
            }
        
            if( $deleteSelf ) {
                $result = unlink( $dir );
                return $result;
            }
        }
    }
    
    /**
     * Recursively copy a directory
     * 
     * @link    http://stackoverflow.com/a/7775949
     * @param   string  $source
     * @param   string  $target
     * @return  void
    */
    public function copyRecursive( $source, $target )
    {
        if( !file_exists( $target ) ) {
            mkdir( $target, 0755, true );
        }

        foreach (
            $iterator = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator( $source, \RecursiveDirectoryIterator::SKIP_DOTS),
                \RecursiveIteratorIterator::SELF_FIRST) AS $item
        ) {
            if ( $item->isDir() ) {
                $targetDir = $target . DIRECTORY_SEPARATOR . $iterator->getSubPathName();
                if( !file_exists( $targetDir ) ) {
                    mkdir( $targetDir );
                }
            } else {
                copy( $item, $target . DIRECTORY_SEPARATOR . $iterator->getSubPathName() );
            }
        }
    }

    /**
     * Slugify a string
     * 
     * @param   string  $string
     * @return  string
    */
    public function slugify( $string )
    {
        $string     = strtolower( $string );    
        $search     = array('_', "'", '!', 'ä', 'ö', 'ü');
        $replace    = array('-', '-', '', 'ae', 'oe', 'ue');
    
        // replace
        $string = str_replace( $search, $replace, $string );
    
        return $string;
    }
    
    /**
     * Encrypt data w/ OpenSSL
     * 
     * @link    https://gist.github.com/glynrob/7059838#file-gistfile1-php
     * @param   string  $string
     * @param   string  $publicKeyPath
     * @return  string
    */
    public function encrypt_openssl( $string, $publicKeyPath ) 
    {
        $fp         = fopen( $publicKeyPath, 'r' );
        $publicKey  = fread( $fp, 8192 );
        
        fclose( $fp );
        
        openssl_get_publickey( $publicKey );   
        openssl_public_encrypt( $string, $encrypted, $publicKey );
        
        return( base64_encode( $encrypted ) );
    }
    
    /**
     * Decrypt data w/ OpenSSL
     *
     * @link    https://gist.github.com/glynrob/7059838#file-gistfile1-php
     * @param   string  $string
     * @param   string  $privateKeyPath
     * @return  string
    */
    public function decrypt_openssl( $string, $privateKeyPath ) 
    {
        $fp         = fopen( $privateKeyPath, 'r' );
        $privateKey = fread( $fp, 8192 );
        
        fclose( $fp );
        
        $privateKey = openssl_get_privatekey( $privateKey );
        
        openssl_private_decrypt( base64_decode( $string ), $decrypted, $privateKey );
        
        return $decrypted;
    }
    
    /**
     * Get the timestamp of the 
     * start of the week
     * 
     * @link    http://derickrethans.nl/calculating-start-and-end-dates-of-a-week.html 
     * @param   int $date
     * @return  int
    */
    public function getStartOfWeek( $date )
    {
        $date = (int)$date;
        if( $date == 0 ) {
            $date = time();
        }
        
        $year = date( 'Y', $date );
        $week = date( 'W', $date );
        
        return strtotime( date( datetime::ISO8601, strtotime( $year.'W'.$week ) ) );    
    }

    /**
     * Get the timestamp of the
     * end of the week
     *
     * @link    http://derickrethans.nl/calculating-start-and-end-dates-of-a-week.html
     * @param   int $date
     * @return  int
    */
    public function getEndOfWeek( $date )
    {
        $date = (int)$date;
        if( $date == 0 ) {
            $date = time();
        }
        
        $year = date( 'Y', $date );
        $week = date( 'W', $date );
            
        return strtotime( date( datetime::ISO8601, strtotime( $year.'W'.$week.'7' ) ) );
    }
    
    /**
     * Get the start of yesterday
     *
     * @link    http://stackoverflow.com/a/16009169
     * @return  int
    */
    public function yesterday()
    {
        return strtotime( '-1 days' );    
    } 
    
    /**
     * Force a file download
     * 
     * @param   string  $filePath
     * @return  mixed   void or boolean
    */
    public function forceDownload( $filePath )
    {
        if ( file_exists( $filePath ) ) {
            header('Content-Description: File Download');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename='.basename( $filePath ) );
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize( $filePath ) );
            readfile( $filePath );
            
            exit;
        } 
        
        return false;
    }    
}
