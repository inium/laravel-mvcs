# laravel-mvcs

Laravel 로 구현된 Repository-Service Scaffolding 구현한 패키지 입니다.

## 개요

Laravel에 Repository - Service를 사용할 수 있도록 Scaffolding 을 만들어주는 패키지 입니다. 

Laravel은 Controller에 Request & Response 처리와 Business Logic을 쉽고 빠르게 구현할 수 있도록 제공합니다. 그러나 이와 같은 구성에서 Business Logic 만의 재사용은 제약이 생길 수 밖에 없습니다. 그래서 일부 Framework(ex. Spring Boot, NestJS) 에서는 관심사(Response & Response, Business Logic, DB Logic 등)를 계층화 하여  (Repository - Service) 사용하는 Layered architecture 패턴을 제공하고 있습니다. 또한 대규모 프로젝트의 경우 관심사를 분리하는 것이 프로젝트가 성공적으로 수행되고 재사용과 지속적인 유지 및 운영되는데 적합합니다.

Laravel은 이러한 Layered Architecture 구현에 필요한 Scaffolding 코드를 제공하고 있지 않습니다. 그래서 Laravel에서 Repository 와 Service 구현을 위해 Scaffolding을 프로젝트에 생성하여 제공해주는 패키지를 제작하였습니다.

본 패키지는 PHP 8.1 / Laravel 9 기반으로 동작합니다.

## 기능

본 패키지는 Controller내 REST API 기본 구현이 포함된 Layered Architecture Scaffolding을 제공합니다. 

### Layered Architecture 구현에 필요한 Scaffolding 생성

본 패키지는 REST API 기본 구현이 필요한 코드를 [사용방법](#사용방법)의 코드 생성 명령어를 통해 아래 항목들을 자동으로 생성하여 줍니다. REST API 기본 구현은 Controller 내 Service Interface를 Injection 하여 사용하도록 구현하였습니다. 

| 항목                            | 설명                                                         | 생성위치 / 파일명 규칙                                       | 비고                     |
| ------------------------------- | ------------------------------------------------------------ | ------------------------------------------------------------ | ------------------------ |
| Controller                      | Request & Response, Service 코드를 호출하는 컨트롤러         | `app/Http/Controllers/{moduleName}Controller.php`            | REST API 구현 포함       |
| Repository                      | Database Logic (Query) 구현 <br />- Interface, Concrete class 생성<br /> | - Interface: `app/Modules/{moduleName}/Interfaces/{moduleName}RepositoryInterface.php`<br />- Concrete: `app/Modules/{moduleName}/{moduleName}Repository.php` |                          |
| Service                         | Business Logic 구현하는 클래스<br />- Interface, Concrete class 생성<br /> | - Interface: `app/Modules/{moduleName}/Interfaces/{moduleName}ServiceInterface.php`<br />- Concrete: `app/Modules/{moduleName}/{moduleName}Service.php` |                          |
| DTO<br />(Data Transfer Object) | Controller -> Service 로 사용자 요청 데이터를 전송하는 객체  | - Page: `app/Modules/{moduleName}/Dto/Page{moduleName}Dto.php`<br />- Create: `app/Modules/{moduleName}/Dto/Create{moduleName}Dto.php`<br /><br />- Update: `app/Modules/{moduleName}/Dto/Update{moduleName}Dto.php`<br /><br />- 일반: `app/Modules/{moduleName}/Dto/{moduleName}Dto.php`<br /> |                          |
| Request                         | 사용자 요청 코드<br />- Page, Create, Update request 생성    | - Page: `app/Http/Requests/{moduleName}/Page{moduleName}Request.php`<br />- Create: `app/Http/Requests/{moduleName}/Create{moduleName}Request.php`<br />- Update: `app/Http/Requests/{moduleName}/Update{moduleName}Request.php`<br /> |                          |
| Model                           | 데이터베이스 모델                                            | `app/Models/{moduleName}.php`                                | --model 옵션 사용시 제외 |
| Database                        | Migration, Factory, Seeders                                  | - Factory: `/database/factories/{moduleName}Factory.php`<br />- Migrations: `/database/migrations/{year}_{month}_{day}_{time}_create_{moduleName}.php`<br />- Seeders: `/database/seeders/`{moduleName}Seeder.php | --model 옵션 사용시 제외 |

## 동작 환경

본 패키지는 PHP 8.1 / Laravel 9 기반으로 동작합니다.

## 사용방법

### 1. Package Install

아래와 같이 Laravel 9.x가 설치된 프로젝트 디렉터리 내에서 `composer` 명령어를 이용해 설치합니다.

```bash	
> composer require inium/laravel-mvcs
```

### 2. 코드 생성

패키지 설치 후 아래 명령어를 이용해 repository - service Scaffolding 코드를 생성하여 사용합니다.

```bash
> php artisan mvcs:create {moduleName} {option:--all|--module}
```

명령어의 Parameter는 아래와 같습니다.

- moduleName: 클래스 이름입니다. ex) 게시판의 경우 Board, Post, Comment 등
- option: 생성 옵션이며 2가지가 있습니다. 
  - `--all`: Request, Controller, Repository(interface, concrete), Service(interface, concrete), DTO + Model, Database (factories, migrations, seeders) 의 Scaffolding을 생성합니다. option이 없을 경우 기본값으로 사용됩니다.
  - `--module`: --all 옵션에서 Model, Database를 제외한 Request, Controller, Repository(interface, concrete), Service(interface, concrete), DTO의 Scaffolding을 생성합니다.

게시판의 게시글 클래스(Post) 생성 사용 예는 아래와 같습니다.

- 모든 Scaffolding 코드을 생성할 경우: `php artisan mvcs:create Post --all` 혹은 `php artisan mvcs:create Post`
- --all 옵션에서 Model, Database를 제외한 Scaffolding 코드를 생성할 경우: `php artisan mvcs:create Post --module`

### 3. (Optional) 생성한 Interface - concrete 클래스의 Bind 대행 Provider 생성

코드를 생성한 후 Repository, Service 클래스 사용을 위해서는 `AppServiceProvider`에 interface -> concrete 클래스를 `bind` 해주어야 합니다. 

그러나 bind할 interface - concrete 클래스가 많아지면 매번 수동으로 입력해주어야 합니다. 그래서 본 패키지에서는 정해진 규칙으로 `app/Modules` 디렉터리에 interface - concrete Scaffolding 들을 Publish 해주고 있기 때문에 이 과정을 줄이고자 `bind`를 대행해주는 Service Provider를 제공하고 있습니다. 

> **주의: 제공하는 Service Provider를 사용할 경우 특정 interface - concrete 클래스의 bind 수정은 불가능합니다.** 
>
> 예를 들어, PostServiceInterface -> PostService를 PostServiceInterface -> PostNewService 로 변경하고자 할 경우 제공하는 Service Provider 클래스에서는 변경이 불가능합니다. 이 경우 제공하는 Service Provider 사용을 중지하고 직접 `bind`를 해야 합니다.

#### 3-1. Publish provider

아래 명령어를 실행하면 `app/Providers`내 MvcsServiceProvider.php가 생성됩니다. 이 클래스는 본 패키지의 명령어를 통해 생성한 interface-concrete class를 `bind` 해주는 코드가 구현되어 있습니다.

```bash	
> php artisan vendor:publish --tag=mvcs-provider
```

#### 3-2. `config/app.php`에 Provider 등록

Publish한 provider를 사용하기 위해서는 `config/app.php` 내 providera 항목에 아래와 같이 provider를 등록해주어야 합니다.

```php
// config/app.php
return [
  ...
  "providers" => [
    ...
    /*
     * Package Service Providers...
     */
    App\Providers\MvcsServiceProvider::class,
    ...
  ]
];
```

## Example	

본 패키지를 이용해 구현한 게시판, 게시글, 게시글 댓글을 구현한 코드가 Laravel 구조에 맞추어 [example](./example) 디렉터리에 저장되어 있으니 참고 바랍니다.

- API에 대한 내용은 vscode의 [REST Client](https://marketplace.visualstudio.com/items?itemName=humao.rest-client)로 구현된 아래 파일 참고 바랍니다.
  - 게시판 API: [`/example/board.rest.http`](./example/board.rest.http) 
  - 게시글 API: [`/example/post.rest.http`](./example/post.rest.http )
  - 게시글 댓글 API: [`/example/comment.rest.http`](./example/comment.rest.http)

## LICENSE

MIT
