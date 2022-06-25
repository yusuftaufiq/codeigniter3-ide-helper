<h1 align="center">
  <a href="https://github.com/yusuftaufiq/codeigniter3-ide-helper"><img src="https://raw.githubusercontent.com/yusuftaufiq/codeigniter3-ide-helper/main/images/ci3-ide-helper-logo.svg"
      width="300"></a>
</h1>

<p align="center">
  <a href="https://github.com/yusuftaufiq/codeigniter3-ide-helper/actions/workflows/lint.yml">
    <img alt="Lint Codebase Workflow Status"
      src="https://img.shields.io/github/workflow/status/yusuftaufiq/codeigniter3-ide-helper/Lint%20Codebase?label=lint&logo=github&style=flat-square">
  </a>
  <a href="https://github.com/yusuftaufiq/codeigniter3-ide-helper/actions/workflows/test.yml">
    <img alt="Test Workflow Status"
      src="https://img.shields.io/github/workflow/status/yusuftaufiq/codeigniter3-ide-helper/Run%20Tests?label=test&logo=github&style=flat-square">
  </a>
  <a href="https://codecov.io/gh/yusuftaufiq/codeigniter3-ide-helper">
    <img alt="Code Coverage"
      src="https://img.shields.io/codecov/c/github/yusuftaufiq/codeigniter3-ide-helper?logo=codecov&style=flat-square">
  </a>
  <a href="https://packagist.org/packages/haemanthus/codeigniter3-ide-helper">
    <img alt="Packagist Version"
      src="https://img.shields.io/packagist/v/haemanthus/codeigniter3-ide-helper?logo=packagist&style=flat-square">
  </a>
  <a href="https://hub.docker.com/repository/docker/haemanthus/codeigniter3-ide-helper">
    <img alt="Docker Image Version (latest semver)" src="https://img.shields.io/docker/v/haemanthus/codeigniter3-ide-helper?logo=docker&label=docker%20hub&sort=semver&style=flat-square">
  <a href="https://github.com/yusuftaufiq/codeigniter3-ide-helper/blob/main/LICENSE">
    <img alt="License"
      src="https://img.shields.io/github/license/yusuftaufiq/codeigniter3-ide-helper?style=flat-square">
  </a>
</p>

## About CodeIgniter 3 IDE Helper

CodeIgniter 3 IDE Helper is a CLI application for generating a helper file to provide automatic code completion for your IDE.

IDE helper output is generated based on all the libraries and models you loaded in the [`config/autoload.php`](https://github.com/bcit-ci/CodeIgniter/blob/master/application/config/autoload.php), [`core`](https://github.com/bcit-ci/CodeIgniter/blob/master/application/core), [`controllers`](https://github.com/bcit-ci/CodeIgniter/blob/master/application/controllers), and [`models`](https://github.com/bcit-ci/CodeIgniter/blob/master/application/models) folders.

## Usage

### Via Composer

Installation via Composer (require PHP >= 7.4)

- First, install with `composer require haemanthus/codeigniter3-ide-helper --dev`
- Then, you can use it with `./vendor/bin/ide-helper generate`

### Via Docker

Alternatively, you can install this package via Docker if for whatever reason you don't have and can't install PHP >= 7.4.

- Pull latest Docker image with `docker pull haemanthus/codeigniter3-ide-helper`
- Then, you can use it with `docker run -it --rm -v "$(pwd):/app" haemanthus/codeigniter3-ide-helper generate`

## Usage Example

<p align="center">
  <img width="600" src="https://raw.githubusercontent.com/yusuftaufiq/codeigniter3-ide-helper/main/images/ci3-ide-helper-usage.gif">
</p>


## Options

| Commands | Options | Description | Example |
| -- | -- | -- | -- |
| ./vendor/bin/ide-helper generate | `--dir` | Set CodeIgniter 3 root directory [default: `./`]. | - |
| | `--pattern` | Add pattern in string or regex to match files (multiple values allowed). | `--pattern '/Controller\b/'` (Match all files with 'Controller' suffix) |
| | | | `--pattern User --pattern Auth` (Match all files with filename containing 'User' or 'Auth') |
| | `--output-path` | Output path of generated file [default: `_ide_helper.php`] | `--output-path ./application/_my_ide_helper.php` |
| | `--help` | Display help. | - |
| | `--quiet` | Do not output any message. | - |
| | `--version` | Display application version. | - |
| | `--no-interaction` | Do not ask any interactive question. | - |

## Contributing

Feel free to contribute, but as this repository release cycle is fully automated using [GitHub Actions Workflows](./.github/workflows/) & [Semantic Release](https://github.com/semantic-release/semantic-release), so make sure your commit messages follow [Conventional Commits Specification](https://www.conventionalcommits.org/en/v1.0.0/).

## Features for Contributors

- Interactive commit with [Commitizen](https://github.com/commitizen/cz-cli).

  Once you are done making your changes, you can run `npx cz` to bring up a prompt which needs to be filled in according to the [Conventional Commits Specification](https://www.conventionalcommits.org/en/v1.0.0/).

- Print debugging with [Symfony Var Dumper](https://symfony.com/doc/current/components/var_dumper.html).

  Debugging CLI applications is very difficult, especially when you are dealing with complex data structures. So to minimize this problem, you can also do print debugging where the results of something you print appear in the browser.

  - First, you can run `composer dumper:start`
  - Open a new terminal then run `composer dumper:serve`
  - Then anywhere inside [`src`](./src/) folder (except [`Application.php`](./src/Application.php), [`Commands/GenerateHelperCommand.php`](./src/Commands/GenerateHelperCommand.php) & [`Providers/AppServiceProvider.php`](./src/Providers/AppServiceProvider.php) files), you can write `dump($something)` or `dd($something)`
  - See the result by opening [http://localhost:8000](http://localhost:8000) in your browser

- Developing inside a Container with [Visual Studio Code Remote Container](https://code.visualstudio.com/docs/remote/containers).

  If you want to develop or explore the source code in this repository further, but you are lazy to install PHP, Composer, Node.js, and various other dependencies. You can also use VS Code Remote Container, just make sure you have Docker & VS Code with [Remote Containers](https://marketplace.visualstudio.com/items?itemName=ms-vscode-remote.remote-containers) installed.

## License

This application is licensed under the [MIT license](http://opensource.org/licenses/MIT).
