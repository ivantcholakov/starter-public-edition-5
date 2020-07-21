<?php

namespace Common\Config;

/**
 * @author Ivan Tcholakov <ivantcholakov@gmail.com>, 2014-2020
 * @license The MIT License, http://opensource.org/licenses/MIT
 */

use CodeIgniter\Config\BaseConfig;

class FileTypeIcons extends BaseConfig
{
    public function __construct() {

        // The icon keys are intended to be compatible with FontAwesome's and Semantic UI's icon names.
        $this->icons = [
            'archive'    => ['7z','ace','adf','air','apk','arj','bz2','bzip','cab','d64','dmg','git','hdf','ipf','iso','fdi','gz','jar','lha','lzh','lz','lzma','pak','phar','pkg','pimp','rar','safariextz','sfx','sit','sitx','sqx','sublime-package','swm','tar','tgz','wim','wsz','xar','zip'],
            'audio'      => ['aac','ac3','aif','aiff','au','caf','flac','it','m4a','m4p','med','mid','mo3','mod','mp1','mp2','mp3','mpc','ned','ra','ram','oga','ogg','oma','s3m','sid','umx','wav','webma','wv','xm'],
            'excel'      => ['xls','xlsx','numbers'],
            'image'      => ['ai','bmp','cdr','emf','eps','gif','icns','ico','jp2','jpe','jpeg','jpg','jpx','pcx','pict','png','psd','psp','svg','tga','tif','tiff','webp','wmf'],
            'pdf'        => ['pdf'],
            'powerpoint' => ['pot','ppt','pptx','key'],
            'code'       => ['ahk','as','asp','aspx','bat','c','cfm','clj','cmd','cpp','css','el','erb','g','hml','java','js','json','jsp','less','nsh','nsi','php','php3','pl','py','rb','rhtml','sass','scala','scm','scpt','scptd','scss','sh','shtml','wsh','xml','yml'],
            'text'       => ['ans','asc','ascii','csv','diz','latex','log','markdown','md','fbmd','nfo','rst','rtf','tex','text','txt'],
            'video'      => ['3g2','3gp','3gp2','3gpp','asf','avi','bik','bup','divx','flv','ifo','m4v','mkv','mkv','mov','mp4','mpeg','mpg','rm','rv','ogv','qt','smk','swf','vob','webm','wmv','xvid'],
            'word'       => ['doc','docm','docs','docx','dot','pages'],
        ];
    }

//------------------------------------------------------------------------------

}
