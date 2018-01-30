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

You'll need to have a PHP development environment to work on this project.
At the very least you should have PHP 7.0 and MySQL 5.7.

>  A fairly simple way to get a compatible development environment setup is to
>  use [Laravel Homestead](https://laravel.com/docs/5.5/homestead) which uses
>  Vagrant and VirtualBox.

1. Clone this git repo to your machine
2. Point your web server at the `public` folder
3. Create a new database (ideally MySQL, but SQLite should also work)
4. Copy `config/phinx.dist.php` to `config/phinx.php` and configure the
   database credentials
5. Make sure you have [composer](https://getcomposer.org/) installed
6. Run `composer install`
7. Run `vendor/bin/phinx migrate`
8. Run `vendor/bin/phinx seed:run`

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

When you're done, submit a [pull request](https://help.github.com/articles/creating-a-pull-request-from-a-fork/).

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

### Other Significant Information

We use [Phinx](https://phinx.org/) for database migrations. It is available via
`vendor/bin/phinx` once you've done a `composer install`. Any database changes
you make need to be committed to your repo as phinx migrations.

Bonus points for unit tests, but at this stage of the game it's not a requirement
especially for code that interacts with the database.
