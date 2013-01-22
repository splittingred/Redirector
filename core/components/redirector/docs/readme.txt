--------------------
3PC: Redirector
--------------------
Version: 1.0.4
Since: April 21st, 2010
Author: Shaun McCormick <shaun@collabpad.com>, Jason Coward <jason@collabpad.com> and Emmanuel Prochasson <eprochasson@gmail.com>

Handles 301 redirects for your site. Logs 404 error to allow quick integration of new redirect rules if required.

You can create two kinds of rule. Plain text (default) will perform exact match on the pattern and redirect to the target.
Regexp will perform Regular Expression matching and Replacing.

Rules are applied in their priority order, however, plain text rules are always tried before the Regexp ones.

IT IS VERY EASY TO GENERATE INFINITE REDIRECTION LOOP, so use with caution.