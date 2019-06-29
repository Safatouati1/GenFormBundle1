# GenFormBundle
#Hi this bundle created by safa touati for sofiatech 
submited on 29/06/2019
#make sure that you follow all the insctructions to make your bundle working
#this bundle helps you to make a form generator or to reuse all our tasks in your symfony project 
#GenFormBundle adds support for creating dynamic forms. It can be used for contact, sweepstake or other forms.
#Features :
#Configuration and management of forms:
#- management of the questions.
#- mail handling.
#- catalogs of the forms.
#- Forms management.
#statistics generation and response processing:
#- Submission of answers
#-response histories.
#- generating answer's statistics.
#- Notification by receiving new replies.
requires
symfony/symfony: 4.2
symfony/swiftmailer-bundle: "^3.2",
symfony/orm-pack: "^1.0",
doctrine/doctrine-fixtures-bundle": "^3.1",
php:  ^7.0
Configuration :
CREATE YOUR USER CLASSE 
ADD ALL THE ANNOTATION NEEDED IN YOUR USER ENTITY 
CREATE THE AUTHENTIFICATION CLASS 
DO NOT FORGET TO USE YOUR SWIFTMAILER EMAIL
ADD THOSE LINES INTO YOUR ROOT FILE 
app_file:
    # loads routes from the given routing file stored in some bundle
    resource: '@SofiaGenFormBundle/Controller'
    type:     annotation
