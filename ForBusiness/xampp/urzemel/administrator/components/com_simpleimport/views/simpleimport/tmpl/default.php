<?php
 
// No direct access
 
defined('_JEXEC') or die('Restricted access'); 
JHTML::stylesheet('simpleimport.css', 'administrator/components/com_simpleimport/styles/');
?>

<h1 style="text-align:center;">Simple Import for Virtuemart 2.0</h1>
<div class="divider"></div>
<div class="container">
  <div class="file-input">
    <h3>Import Product File</h3>
    <form method="post" action="index.php" enctype="multipart/form-data">
        <fieldset>
            <legend>Upload Files</legend>
    
            <div class="form-row">
                <input type="file" id="file" name="file" /><br>
                <input type="hidden" name="option" value="com_simpleimport" />                 
                <input type="hidden" name="controller" value="importdata" />                 
                <input type="hidden" name="task" value="importdata" />                        
            </div>
    
            <div class="form-row">
                <input type="submit" id="submit" name="submit" value="Upload">
            </div>
    
    </fieldset>
    </form>
    <a style="text-decoration:none;" href="http://virtuemartjoomla.com/virtuemart-joomla-extensions-components-import/virtuemart-joomla-simple-import.html" target="_blank"><img src="components/com_simpleimport/images/virtuemart-simple-import-250.png" width="250" height="263" /></a></div>
    <div class="offers">
        <h3>More Great Products @ <a href="http://virtuemartjoomla.com/" target="_blank">VirtuemartJoomla.com</a></h3>
        <p><a href="http://virtuemartjoomla.com/virtuemart-joomla-extensions-components-import/virtuemart-joomla-simple-import.html" target="_blank">Simple Import Pro</a></p>
        <p>Upgrade from the FREE version to the Pro version</p>
      <ul>
          <li>Detailed reporting of Product Import</li>
      </ul>
      <a href="http://virtuemartjoomla.com/virtuemart-joomla-extensions-components-import/virtuemart-joomla-google-product-feed-generator.html" target="_blank">vGoogle Feed</a>
      <ul>
        <li>Submitting your product feed to Google is a MUST</li>
          <li>The easiest way to generate your Google Feed</li>
      </ul>
        <p><a href="http://virtuemartjoomla.com/virtuemart-joomla-hosting.html" target="_blank">Virtuemart Hosting</a></p>
        <ul>
          <li>Leave all of the technical details and tweaks to us</li>
          <li>Includes: Simple Import PRO and vGoogle Feed</li>
      </ul>
      <p><a href="http://virtuemartjoomla.com/virtuemart-joomla-complete-store.html" target="_blank">The Complete Virtuemart Solution</a></p>
        <ul>
          <li>How would you like a store with products already loaded.</li>
          <li>Get started immediately, then load your products as you go.</li>
          <li>Make money immediately while you spend months learning.</li>
      </ul>
      <p><a href="http://www.shareasale.com/r.cfm?u=613742&b=269852&m=30300&afftrack=com%5Fsimpleimport&urllink=www%2Erockettheme%2Ecom%2Fjoomla%2Dtemplates%2Fmynxx" target="_blank">The Best Virtuemart Template</a></p>
        <ul>
          <li>In our opinion, the best Virtuemart template to date is Mynxx</li>
      </ul>
  </div>
    <div style="clear:both;"></div>
    <div class="content">
    <p>Download the <a href="components/com_simpleimport/images/simple-import-free.pdf" target="_blank">PDF Simple Import User Manual</a></p>
    <p>Download the <a target="_blank" href="components/com_simpleimport/import-template.php">CSV template file</a>.</p>
  </div>
</div>
<div style="text-align:center; font-size:18px;">
eMail - Support@VirtuemartJoomla.com
</div>