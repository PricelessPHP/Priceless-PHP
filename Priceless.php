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
        $search     = array('_', "'", '!', 'ä', 'ö', 'ü', 'ß');
        $replace    = array('-', '-', '', 'ae', 'oe', 'ue', 'ss');
    
        // replace
        $string = str_replace( $search, $replace, $string );
    
        return $string;
    }
	
	/**
	 * Create a web friendly URL slug from a string.
	 * 
	 * Although supported, transliteration is discouraged because
	 *     1) most web browsers support UTF-8 characters in URLs
	 *     2) transliteration causes a loss of information
	 *
	 * @author Sean Murphy <sean@iamseanmurphy.com>
	 * @copyright Copyright 2012 Sean Murphy. All rights reserved.
	 * @license http://creativecommons.org/publicdomain/zero/1.0/
	 *
	 * @param string $str
	 * @param array $options
	 * @return string
	 */
	public function slugify_text( $str, $options = array() ) 
	{
		// Make sure string is in UTF-8 and strip invalid UTF-8 characters
		$str = mb_convert_encoding( (string)$str, 'UTF-8', mb_list_encodings() );

		$defaults = array(
			'delimiter' => '-',
			'limit' => null,
			'lowercase' => true,
			'replacements' => array(),
			'transliterate' => true,
		);

		// Merge options
		$options = array_merge( $defaults, $options );

		$char_map = array(
			// German
			'Ä' => 'AE', 'Ö' => 'OE', 'Ü' => 'UE',
			'ä' => 'ae', 'ö' => 'oe', 'ü' => 'ue',
			
			// Latin
			'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'AE', 'Ç' => 'C', 
			'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 
			'Ð' => 'D', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ő' => 'O', 
			'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ű' => 'U', 'Ý' => 'Y', 'Þ' => 'TH', 
			'ß' => 'ss', 
			'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'ae', 'ç' => 'c', 
			'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 
			'ð' => 'd', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ő' => 'o', 
			'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'ű' => 'u', 'ý' => 'y', 'þ' => 'th', 
			'ÿ' => 'y',
			
			// Latin symbols
			'©' => '(c)',
			
			// Greek
			'Α' => 'A', 'Β' => 'B', 'Γ' => 'G', 'Δ' => 'D', 'Ε' => 'E', 'Ζ' => 'Z', 'Η' => 'H', 'Θ' => '8',
			'Ι' => 'I', 'Κ' => 'K', 'Λ' => 'L', 'Μ' => 'M', 'Ν' => 'N', 'Ξ' => '3', 'Ο' => 'O', 'Π' => 'P',
			'Ρ' => 'R', 'Σ' => 'S', 'Τ' => 'T', 'Υ' => 'Y', 'Φ' => 'F', 'Χ' => 'X', 'Ψ' => 'PS', 'Ω' => 'W',
			'Ά' => 'A', 'Έ' => 'E', 'Ί' => 'I', 'Ό' => 'O', 'Ύ' => 'Y', 'Ή' => 'H', 'Ώ' => 'W', 'Ϊ' => 'I',
			'Ϋ' => 'Y',
			'α' => 'a', 'β' => 'b', 'γ' => 'g', 'δ' => 'd', 'ε' => 'e', 'ζ' => 'z', 'η' => 'h', 'θ' => '8',
			'ι' => 'i', 'κ' => 'k', 'λ' => 'l', 'μ' => 'm', 'ν' => 'n', 'ξ' => '3', 'ο' => 'o', 'π' => 'p',
			'ρ' => 'r', 'σ' => 's', 'τ' => 't', 'υ' => 'y', 'φ' => 'f', 'χ' => 'x', 'ψ' => 'ps', 'ω' => 'w',
			'ά' => 'a', 'έ' => 'e', 'ί' => 'i', 'ό' => 'o', 'ύ' => 'y', 'ή' => 'h', 'ώ' => 'w', 'ς' => 's',
			'ϊ' => 'i', 'ΰ' => 'y', 'ϋ' => 'y', 'ΐ' => 'i',
			
			// Turkish
			'Ş' => 'S', 'İ' => 'I', 'Ç' => 'C', 'Ü' => 'U', 'Ö' => 'O', 'Ğ' => 'G',
			'ş' => 's', 'ı' => 'i', 'ç' => 'c', 'ü' => 'u', 'ö' => 'o', 'ğ' => 'g', 
			
			// Russian
			'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'Yo', 'Ж' => 'Zh',
			'З' => 'Z', 'И' => 'I', 'Й' => 'J', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O',
			'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
			'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sh', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'Yu',
			'Я' => 'Ya',
			'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'ж' => 'zh',
			'з' => 'z', 'и' => 'i', 'й' => 'j', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o',
			'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c',
			'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sh', 'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu',
			'я' => 'ya',
			
			// Ukrainian
			'Є' => 'Ye', 'І' => 'I', 'Ї' => 'Yi', 'Ґ' => 'G',
			'є' => 'ye', 'і' => 'i', 'ї' => 'yi', 'ґ' => 'g',
			
			// Czech
			'Č' => 'C', 'Ď' => 'D', 'Ě' => 'E', 'Ň' => 'N', 'Ř' => 'R', 'Š' => 'S', 'Ť' => 'T', 'Ů' => 'U', 
			'Ž' => 'Z', 
			'č' => 'c', 'ď' => 'd', 'ě' => 'e', 'ň' => 'n', 'ř' => 'r', 'š' => 's', 'ť' => 't', 'ů' => 'u',
			'ž' => 'z', 
			
			// Polish
			'Ą' => 'A', 'Ć' => 'C', 'Ę' => 'e', 'Ł' => 'L', 'Ń' => 'N', 'Ó' => 'o', 'Ś' => 'S', 'Ź' => 'Z', 
			'Ż' => 'Z', 
			'ą' => 'a', 'ć' => 'c', 'ę' => 'e', 'ł' => 'l', 'ń' => 'n', 'ó' => 'o', 'ś' => 's', 'ź' => 'z',
			'ż' => 'z',
			
			// Latvian
			'Ā' => 'A', 'Č' => 'C', 'Ē' => 'E', 'Ģ' => 'G', 'Ī' => 'i', 'Ķ' => 'k', 'Ļ' => 'L', 'Ņ' => 'N', 
			'Š' => 'S', 'Ū' => 'u', 'Ž' => 'Z',
			'ā' => 'a', 'č' => 'c', 'ē' => 'e', 'ģ' => 'g', 'ī' => 'i', 'ķ' => 'k', 'ļ' => 'l', 'ņ' => 'n',
			'š' => 's', 'ū' => 'u', 'ž' => 'z'
		);

		// Make custom replacements
		$str = preg_replace(array_keys($options['replacements']), $options['replacements'], $str);

		// Transliterate characters to ASCII
		if ($options['transliterate']) {
			$str = str_replace(array_keys($char_map), $char_map, $str);
		}

		// Replace non-alphanumeric characters with our delimiter
		$str = preg_replace('/[^\p{L}\p{Nd}]+/u', $options['delimiter'], $str);

		// Remove duplicate delimiters
		$str = preg_replace('/(' . preg_quote($options['delimiter'], '/') . '){2,}/', '$1', $str);

		// Truncate slug to max. characters
		$str = mb_substr($str, 0, ($options['limit'] ? $options['limit'] : mb_strlen($str, 'UTF-8')), 'UTF-8');

		// Remove delimiter from ends
		$str = trim($str, $options['delimiter']);

		return $options['lowercase'] ? mb_strtolower($str, 'UTF-8') : $str;
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
    
    /**
     * Return a date formatted in
     * the German locale
     *
     * @param   int     $date
     * @param   string  $format
     * @return  string
    */
    public function german_date( $date, $format = '%d.%m.%Y' )
    {
        // get the current locale
        $originalLocale = setlocale( LC_TIME, '0' );
    
        // change the locale to German
        setlocale( LC_TIME, 'de_DE.utf8' );
    
        // format
        $formattedDate = strftime( $format, $date );
    
        // reset the locale
        setlocale( LC_TIME, $originalLocale );
    
        return $formattedDate;   
    }
    
    /**
     * Format a number in German format
     *
     * @param   int     $number
     * @return  string
    */
    public function german_number_format( $number )
    {
        return number_format( $number, 2, ',', '.' );    
    }
    
    /**
     * Return a date formatted in
     * a specific locale
     *
     * @param   int     $date
     * @param   string  $locale
     * @param   string  $format
     * @return  string
    */
    public function localized_date( $date, $locale, $format = '%m &d %Y' )
    {
        // get the current locale
        $originalLocale = setlocale( LC_TIME, '0' );
    
        // change the locale
        setlocale( LC_TIME, $locale );
    
        // format
        $formattedDate = strftime( $format, $date );
    
        // reset the locale
        setlocale( LC_TIME, $originalLocale );
    
        return $formattedDate;   
    }    
}
