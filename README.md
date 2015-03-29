Contao 3 Module: Proxy
======================
[![Latest Stable Version](https://poser.pugx.org/bugbuster/contao-proxy/v/stable.svg)](https://packagist.org/packages/bugbuster/contao-proxy) [![Total Downloads](https://poser.pugx.org/bugbuster/contao-proxy/downloads.svg)](https://packagist.org/packages/bugbuster/contao-proxy) [![Latest Unstable Version](https://poser.pugx.org/bugbuster/contao-proxy/v/unstable.svg)](https://packagist.org/packages/bugbuster/contao-proxy) [![License](https://poser.pugx.org/bugbuster/contao-proxy/license.svg)](https://packagist.org/packages/bugbuster/contao-proxy)

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/71a3f87d-bb25-44ed-a6a4-3f24de6bb844/small.png)](https://insight.sensiolabs.com/projects/71a3f87d-bb25-44ed-a6a4-3f24de6bb844)

Fork from the old TYPOlight Module „Proxy“. Proxy for the backend extension catalog (ER2).

Description
-----------

No official transfer! I have changed the Module for using with Contao 3.x

### Installation

-   Download the ZIP file
-   unpack on your hard drive
-   on the server in the directory `system/modules` , create a new directory `proxy`
-   copy into the directory `system/modules/proxy` then the files and directories

So then there must exist:

-   `system/modules/proxy/classes/Proxy.php`
-   `system/modules/proxy/config/autoload.php`
etc.

### Using

In the backend, in System - Settings, there is now the new section  "Proxy
configuration (outgoing connections)".  When the extension catalog and
installation works, the module should be  installed again over the extension
catalog. So updates are displayed in  the extension manager, if there is one.


Beschreibung
------------

Keine offizielle Übernahme! Ich habe das Modul für Contao 3.x angepasst, um
weiter damit arbeiten zu können.

### Manuelle Installation

-   Download ZIP Datei, oben auf dieser Seite über "releases"
-   auf lokaler Festplatte auspacken
-   auf dem Server im Verzeichnis `system/modules` ein neues Verzeichnis `proxy` anlegen
-   in das Verzeichnis `system/modules/proxy` nun die Dateien und Verzeichnisse übertragen

Es muss also damit existieren:

-   `system/modules/proxy/classes/Proxy.php`
-   `system/modules/proxy/config/autoload.php`
usw.

### Nutzung

Im Backend unter System - Einstellungen ist der Abschnitt "Proxy-Einstellungen
(abgehende Verbindungen)" zu finden.

Sobald damit der Erweiterungskatalog und die Installation funktioniert, sollte
das Modul Proxy nochmal über den Erweiterungskatalog installiert werden. 
Damit werden Updates in der Verwaltung angezeigt, sofern welche vorhanden sind.
