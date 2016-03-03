# sf3Base

Little Symfony 3 base skeleton with common component

- Authentication based on FOS-User Module - todo
- ACL Module - todo
- Rest Module - todo
- CRUD Module - done

# Project Creation 
- Create Project :: php symfony.phar new sf3Base
- Create new Bundle :: php bin/console generate:bundle --bundle-name=VascoCrudBundle
- Create new Controller :: php bin/console generate:controller --controller=VascoCrudBundle:Todo
- Create new Entity :: php bin/console generate:doctrine:entity --entity=VascoCrudBundle:Todo
- Create the Database Tables/Schema :: php bin/console doctrine:schema:update --force
	
