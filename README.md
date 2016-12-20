# Pinpoint.Links

This is a small project that we ask applicants to complete as part of the
application process.

It's designed to be a simple application following some of the standards and
practices that we use in our production applications.

**Please e-mail me at
[shell@pinpointsoftware.co](mailto:shell@pinpointsoftware.co) if you run into
problems. I will expect that you can explain to me what you've tried and what
steps you've taken on your own to troubleshoot the issue.**

**This project is just as much (if not more so) to see how well you communicate
about issues as it is about your abilities as a PHP developer.**

## Installation

### Vagrant Installation

[Vagrant](https://www.vagrantup.com/) is probably the easiest way to get the app
up and running. It uses [VirtualBox](https://www.virtualbox.org/wiki/VirtualBox)
to create a development virtual machine.  If you have Vagrant and VirtualBox
installed, you should be able to just run `vagrant up` and have a dev server
boot up for you.

To make things easier you will probably want to have the following Vagrant
plugins installed:

-  [vagrant-hostsupdater](https://github.com/cogitatio/vagrant-hostsupdater)
-  [vagrant-vbguest](https://github.com/dotless-de/vagrant-vbguest)

When you're done you should be able to go to
[pinpoint.dev](http://pinpoint.dev/). If you didn't have vagrant-hostsupdater
installed you may need to add a record for pinpoint.dev pointing to
192.168.56.101 in your hosts file.

### Manual Installation

If you'd prefer to manually install the application these are the steps:

1. Clone this git repo to your machine
2. Point your web server at the `public` folder
3. Create a new database (ideally MySQL, but SQLite should also work)
4. Copy `config/phinx.dist.php` to `config/phinx.php` and configure the
   database credentials
5. Make sure you have [composer](https://getcomposer.org/),
   [Node.js](https://nodejs.org/en/), [gulp](http://gulpjs.com/), and
   [bower](https://bower.io/) installed
6. Run `composer install`
7. Run `bower install`
8. Run `gulp less`
9. Run `vendor/bin/phinx migrate`
10. Run `vendor/bin/phinx seed:run`

You should now have a running version of the application.

## The Project

This application is a very simple link sharing site.

Assuming the `phinx` scripts ran you should have a few links already listed. You
should be able to log in with the email `admin@pinpointsoftware.co` and
password `p4ssw0rd!`.

Once you login, you should now be able to click on "Submit" in the nav bar and
submit new links.

### New Feature

What I'd like you to do, is add the ability to submit text instead of a URL
(like on [Hacker News](https://news.ycombinator.com/)). Then when the title
shows on the homepage, clicking it would take you to a page that shows the text.
There doesn't need to be any support for Markdown or anything, plain text is
fine.

This should be done in a fork of this repo (see
[Forking Projects](https://guides.github.com/activities/forking/)).



### Architecture

Our application is built in a way you may not be familiar with. We use a few
patterns that I'll try to explain.

#### Clean Architecture

I'm a big fan of Robert "Uncle Bob" Martin and his
[Clean Architecture](https://8thlight.com/blog/uncle-bob/2012/08/13/the-clean-architecture.html)
pattern.

This means that I try to isolate my domain logic from hard dependencies and
prefer to depend on interfaces that I create. I can then implement those
interfaces using existing libraries without worrying that if I have to
change things, that I'll have to rewrite all of my code.

#### CQRS

First read the very good explanation by Martin Fowler on
[CQRS](http://martinfowler.com/bliki/CQRS.html).

What that means for us is that the main application either reads data from the
database or submits a command to a command bus to do work. We can then write
listeners that read commands from the command bus and actually write to the
database.

We're using [AtlasORM](https://github.com/atlasphp/Atlas.Orm) to read and write
to the database and [Tactician](https://tactician.thephpleague.com/) as our
command bus.

#### Action-Domain-Responder (ADR)

ADR is a pattern described by Paul M. Jones in
[Action-Domain-Responder](http://pmjones.io/adr/). The gist is that instead of
having monolithic controllers that do everything from handling the request,
querying the database, and populating the templates, that we break them up into
smaller pieces.

We're using Paul's ADR framework
[Radar](https://github.com/radarphp/Radar.Project/blob/1.x/docs/index.md)
which itself is built using other projects that Paul built like
[Aura](http://auraphp.com/).

I explain ADR and how Radar implements it in my blog post
[Radar Under the Hood](https://www.futureproofphp.com/2016/09/21/radar-under-the-hood/).
My blog [FutureProof PHP](https://www.futureproofphp.com/) can also be considered
further documentation of how I think about software development and in particular
the libraries I've built and use in this application.
