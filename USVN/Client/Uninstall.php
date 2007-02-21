<?php
/**
* @package client
* @subpackage uninstall
* @since 0.5
*/

require_once 'USVN/Client/SVNUtils.php';
require_once 'USVN/DirectoryUtils.php';

/**
* The uninstall command
*/
class USVN_Client_Uninstall
{
    private $path;

    public function USVN_Client_Uninstall($path)
    {
        if (!USVN_Client_SVNUtils::isSVNRepository($path))
        {
            throw new Exception("$path is not a valid SVN repository");
        }
        $this->path = $path.'/';
        $this->removeHooks();
        USVN_DirectoryUtils::removeDirectory($this->path.'/usvn');
    }

    private function removeHooks()
    {
        foreach (USVN_Client_SVNUtils::$hooks as $hook)
        {
            $dst = $this->path."/hooks/{$hook}";
            if (!@unlink($dst))
            {
                throw new Exception("Can't remove $dst.\nAre your sure that {$this->path} is an usvn repository?");
            }
        }
    }
}