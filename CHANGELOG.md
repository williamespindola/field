# Changelog

All Notable changes to `field` will be documented in this file

## 2015-09-23

### Added
- Multi language support #24
- Refactoring cli Create class to work with language
- Add option via cli
- Add language via cli
- Update mysql schema with new schema without collection and field many to many relationship
- Improve readme

### Deprecated
- Nothing

### Fixed
- option word is reserved on mysql #18
- Config path on WilliamEspindola\Field\Console\Command\Database\DoctrineStorage
- getMapperInstance method on WilliamEspindola\Field\Console\Command\Database\DoctrineStorage must return instance of WilliamEspindola\Field\Storage\ORM\Doctrine not mapper


### Removed
- Remove collection and field n to n relationship #25

### Security
- Nothing