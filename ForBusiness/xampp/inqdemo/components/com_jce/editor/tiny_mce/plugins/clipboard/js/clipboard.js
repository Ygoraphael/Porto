/* jce - 2.6.12 | 2017-04-27 | http://www.joomlacontenteditor.net | Copyright (C) 2006 - 2017 Ryan Demmer. All rights reserved | GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html */
var ClipboardDialog={settings:{},init:function(){var ifr,doc,css,self=this,ed=tinyMCEPopup.editor,el=document.getElementById("container"),title=document.getElementById("title"),cssHTML="";Wf.init(),$("#insert").click(function(e){self.insert(),e.preventDefault}),$("#cancel").click(function(e){tinyMCEPopup.close(),e.preventDefault});var cmd=tinyMCEPopup.getWindowArg("cmd"),msg=ed.getLang("clipboard.paste_dlg_title","Use %s+V on your keyboard to paste text into the window.");title.innerHTML=msg.replace(/%s/g,tinymce.isMac?"CMD":"CTRL"),"mcePaste"==cmd?(document.title=ed.getLang("clipboard.paste_desc"),el.innerHTML='<iframe id="content" src="javascript:\'\';" frameBorder="0"></iframe>',ifr=document.getElementById("content"),doc=ifr.contentWindow.document,css=tinymce.explode(ed.settings.content_css)||[],css.push(ed.baseURI.toAbsolute("themes/"+ed.settings.theme+"/skins/"+ed.settings.skin+"/content.css")),css.push(ed.baseURI.toAbsolute("plugins/clipboard/css/blank.css")),tinymce.each(css,function(u){cssHTML+='<link href="'+ed.documentBaseURI.toAbsolute(""+u)+'" rel="stylesheet" type="text/css" />'}),doc.open(),doc.write('<html><head><base href="'+ed.settings.base_url+'" />'+cssHTML+'</head><body class="mceContentBody" spellcheck="false"></body></html>'),doc.close(),doc.designMode="on",window.setTimeout(function(){ifr.contentWindow.focus()},100)):(document.title=ed.getLang("clipboard.paste_text_desc"),el.innerHTML='<textarea id="content" name="content" dir="ltr" wrap="soft" class="mceFocus"></textarea>')},insert:function(){var h,wc,c=document.getElementById("content");tinyMCEPopup.restoreSelection(),"TEXTAREA"==c.nodeName?(h=c.value,lines=h.split(/\r?\n/),lines.length>1&&(h="",tinymce.each(lines,function(row){h+=tinyMCEPopup.editor.getParam("force_p_newlines")?"<p>"+row+"</p>":row+"<br />"})),wc=!1):(h=c.contentWindow.document.body.innerHTML,wc=!0),tinyMCEPopup.editor.execCommand("mceInsertClipboardContent",!1,{content:h,wordContent:wc}),tinyMCEPopup.close()},resize:function(){var el,vp=tinyMCEPopup.dom.getViewPort(window);el=document.getElementById("content"),el&&(el.style.height=vp.h-110+"px")}};tinyMCEPopup.onInit.add(ClipboardDialog.init,ClipboardDialog);