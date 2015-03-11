<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>{$title}</title>
  <link rel="stylesheet" type="text/css" href="{$css_link}" />
</head>
<body>

<h1 class="pageHeader">{$headline}</h1>

<div class="menu">
{if $username}
  <ul>
    {section name=m loop=$menu_items}<li><a href="{$menu_items[m].link}">{$menu_items[m].title}</a></li>{/section}

  </ul>
{/if}
{*
  <div class="login-link">{if $username}You are logged in as {$username}. <a class="button" href="{$logout_link}">Log out</a>{else}<a class="button" href="{$login_link}">Log in</a>{/if}</div>
*}
</div>

{$content}

{* do not display the footer for now
<address>2006 No copyright <a href="http://benn.org/">Meinhard Benn</a>, informal development sponsored by EYFA - thank you! :o)<br />
Need an online form for your non-profit project? <a href="http://benn.org/email">Contact me!</a></adress>
*}
</body>
</html>
