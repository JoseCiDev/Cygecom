# GECOM - Gerenciador de cotações e compras

## Instalação:

-   Clonar o projeto para pasta projects do Docker
-   Rodar docker compose up na pasta docker-sm (Necessário container php8-projects e db-mysql-8.0)
    (Para acessar o banco de dados é pela porta 3307)
-   Ir para a branch develop - git checkout
-   Rodar composer install
-   Criar arquivo .env a partir de env.example
-   Adicionar na pasta public as pastas font e img do flat
-   Criar banco de dados com nome gerenciador_compras
-   Rodar php artisan migrate
-   Rodar php artisan db:seed
-   Acessar pelo link: <a href="http://gerenciador-compras.docker.local:8082/" target="_blank">http://gerenciador-compras.docker.local:8082/</a>

# Padrões de estrutura

## Introdução

Este documento apresenta um guia geral para a padronização da estrutura de Controllers, Models e Providers do projeto GECOM em Laravel.

## Controllers

Os Controllers são responsáveis por receber as requisições HTTP e coordenar as ações necessárias para atender a essas solicitações. Para manter a organização e a padronização do código, recomenda-se adotar as seguintes práticas:

-   Cada Controller deve estar em um arquivo separado dentro da pasta `app/Http/Controllers`;
-   O nome do arquivo deve seguir o padrão: `NomeDoController.php`, onde `NomeDoController` deve ser o nome do `Controller` em PascalCase;
-   O nome da classe deve seguir o padrão: `NomeDoController`, onde `NomeDoController` deve ser o nome do `Controller` em PascalCase;
-   Todos os métodos do `Controller` devem ser definidos com a visibilidade pública e seguir o padrão: `nomeDoMetodo`, onde `nomeDoMetodo` deve ser um verbo que descreva a ação a ser realizada em camelCase.
-   Em caso de existir dependências deve ser priorizado a injeção de dependências no controlador. Em vez de criar diretamente essas dependências dentro do controlador, elas são passadas para o controlador através do construtor.<br>
    Exemplo:

    ```php
    use App\Providers\{UserService, ValidatorService};

    class UserController extends Controller implements UserControllerInterface
    {
        private $userService;
        private $validatorService;

        public function __construct(UserService $userService, ValidatorService $validatorService)
        {
            $this->userService      = $userService;
            $this->validatorService = $validatorService;
        }
    ```

-   O método de criar ou atualizar registro neste controlador deve tratar possíveis erros quando necessário que podem ocorrer durante o processo request. Da mesma maneira, deve seguir um padrão de tratamento de dados. Aqui está uma explicação do tratamento de dados e de erro:

-   O método recebe por padrão um objeto `Request` que contém os dados enviados na solicitação HTTP.

    -   Observação:<br>
        Em `UserController` há o método create que recebe um `array $data` pelo `trait RegistersUsers` do método `register` de use `_Illuminate\Foundation\Auth\RegistersUsers_`;

        -   Assim o `trait` retorna o parâmetro `$data` como array após usar `$request->all()`;
        -   Quando necessário, deve ser feita uma verificação antes do `try catch`. Por exemplo, no userUpdate verificar o tipo de usuário e antes de continuar o processo. Assim, evita-se processamento de dados desnecessários.<br><br>

        ```php
        public function userUpdate(Request $request, int $id)
        {
            $isAdmin = auth()->user()->profile->name === "admin";
            $isOwnId = $id === auth()->user()->id;

            if (!$isAdmin && !$isOwnId) {
                return redirect()->route('profile');
            }

            try {.........} catch(){}
        ```

-   Iniciar um bloco `try-catch` para capturar possíveis exceções que possam ocorrer durante o processamento, exemplo em caso de criar, atualizar ou deletar registro.

    -   Dentro do bloco `try`, a primeira coisa que é feita normalmente é chamar o respectivo método de validação a partir da injeção `validatorService` .<br>
        Exemplo:<br>

        ```php
        $validator = $this->validatorService->updateValidator($id, $data);

        if ($validator->fails()) {
        return back()->withErrors($validator->errors()->getMessages())->withInput();
        }
        ```

    -   Observação: Para o método `create` de `UserController` é necessário sobrescrever o método `validator` herdado. Neste caminho, usa-se então `$this->validator($data)` para acessar a função:<br>

        ```php
        /**
         * @abstract função necessária para sobreescrever validator padrão;
         * @param array $data Recebe array da request para validação;
         */
        private function validator(array $data)
        {
            $validator = $this->validatorService->registerValidator($data);

            return $validator;
        }
        ```

-   Se a validação dos dados for bem-sucedida, o método desejado é chamado através do serviço responsável pelo processamento de registrar, atualizar, deletar, entre outros, com base nos dados fornecidos.
-   Em seguida, uma mensagem de sucesso é armazenada na sessão, usando`session()->flash()`, para que ela possa ser exibida posteriormente.
-   Por fim, geralmente o método retorna o primeiro modelo da coleção (Exemplo: `$user` tipado como `User`) que foi registrado com sucesso ou retorna um `redirect()` ou algum `view`.
-   Se ocorrer uma exceção durante o processo de atualização, o fluxo de execução será desviado para o bloco `catch`. Dentro desse bloco, é chamado `redirect()->back()`, que redireciona o usuário de volta à página anterior. Além disso, uma mensagem de erro é adicionada usando `withErrors([$error->getMessage()])`, que será exibida na página redirecionada.

## Models

Os `Models` são responsáveis por representar as entidades do sistema e interagir com o banco de dados. Para manter a organização e a padronização do código, recomenda-se adotar as seguintes práticas:

-   Cada `Model` deve estar em um arquivo separado dentro da pasta `Models`;
-   Cada `Model` deve informar sua relação e tipo de relação com outros `Models`;
-   O nome do arquivo deve seguir o padrão: `NomeDoModel.php`, onde 'NomeDoModel' deve ser o nome do `Model` em PascalCase;
-   O nome da classe deve seguir o padrão: `NomeDoModel`, onde 'NomeDoModel' deve ser o nome do `Model` em PascalCase;
-   O `Model` deve estender a classe `Illuminate\Database\Eloquent\Model`;
    -   Especificamente em `Model User` deve ser extendido a classe ` _Authenticatable_` a qual por suaa vez extende a classe `Model`;
-   Os atributos do `Model` devem ser definidos como protegidos e seguir o padrão: `nome_do_atributo`, onde `nome_do_atributo` deve ser um substantivo que descreva a característica da entidade em snake_case;
    Exemplo:
    ```php
    protected $fillable = [
    'email',
    'password',
    'is_buyer',
    'profile_id',
    'person_id',
    'approver_user_id',
    'approve_limit'
    ];
    ```
-   Todos os métodos do Model devem ser definidos com a visibilidade pública e seguir o padrão: `nomeDoMetodo`, onde `nomeDoMetodo` deve ser um verbo que descreva a ação a ser realizada em camelCase.<br>
    Exemplo:

    ```php
    public function user()
        {
            return $this->hasOne(User::class);
        }

    public function phone()
            {
                return $this->hasMany(Phone::class);
            }

    public function costCenter()
        {
            return $this->belongsTo(CostCenter::class, 'cost_center_id');
        }
    ```

## Providers

Os `Providers` são responsáveis por registrar os serviços e as dependências do sistema. Para manter a organização e a padronização do código, recomenda-se adotar as seguintes práticas:

-   Cada Provider deve estar em um arquivo separado dentro da pasta `app/Providers`;
-   O nome do arquivo deve seguir o padrão: `NomeDoProvider.php`, onde `NomeDoProvider` deve ser o nome do Provider em PascalCase;
-   O nome da classe deve seguir o padrão: `NomeDoProvider`, onde `NomeDoProvider` deve ser o nome do Provider em PascalCase;
-   O Provider deve estender a classe `Illuminate\Support\ServiceProvider`;<br><br>

    ```php
    use Illuminate\Support\ServiceProvider;
    class AppServiceProvider extends ServiceProvider
    ```

-   O método `register` deve ser implementado para registrar os serviços e as dependências do sistema. Em `app\Providers\AppServiceProvider.php` deve ser feito o registro dos providers/services;<br><br>

    ```php
    class AppServiceProvider extends ServiceProvider
    {
        /**
         * Register any application services.
         */
        public function register(): void
        {
            $this->app->singleton(UserService::class, function ($app) {
                return new UserService($app);
            });
            $this->app->singleton(ValidatorService::class, function ($app) {
                return new ValidatorService($app);
            });
            $this->app->singleton(ProductService::class, function ($app) {
                return new ProductService($app);
            });
        }
    }
    ```

## Conclusão

Adotar esses padrões de estrutura no projeto GECOM em Laravel é fundamental para garantir a organização e a manutenibilidade do código. Ao seguir as práticas apresentadas neste documento para `Controllers`, `Models` e `Providers`, é possível manter um código limpo, claro e fácil de ser compreendido por toda a equipe de desenvolvimento.

Juntamente a esses padrões deve ser implementar boas práticas como SOLID e código limpo. <a href="https://github.com/PedroPiuma/SOLID-Principles" target="_blank">Clique aqui</a>
