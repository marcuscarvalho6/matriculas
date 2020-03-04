# Avaliação Pluri Tecnologia

Este projeto foi desenvolvido de Marcus Vinícius de Carvalho para processo seletico no que diz respeito a avaliação de conhecimento sobre desenvolvimento back-end, qualidade de código e utilização de conceitos de programação orientada a objetos. Para produção do teste em questão foi escolhido o framework Laravel.


## O Desafio

Criar um projeto que resolva o seguinte problema proposto:

### Cenário fictício

A Pluri Educacional deseja lançar uma nova plataforma de ensino online, onde desejamos
realizar a matrícula de alunos em cursos, através de um painel administrativo.

## Objetivo

Medir o nível de conhecimentos do candidato nas tecnologias exigidas para a vaga.

### Escopo

Criar um WebService Rest em PHP para resolver o problema descrito acima, através de
uma uma aplicação simples, utilizando um dos frameworks: Laravel (nossa preferência),
Codeigniter ou CakePHP.

### Requisitos

- Um aluno pode ser matriculado em mais de um curso
- A consulta pelo nome e e-mail é requisito funcional
- Uma requisição que informe o total de alunos por faixa etária separados por curso e sexo:
    - Menor que 15 anos
    - Entre 15 e 18 anos
    - Entre 19 e 24 anos
    - Entre 25 e 30 anos
    - Maior que 30 anos

### 1. CRUD de Cursos
    - Criar um gerenciamento onde seja possível Criar, Listar, Editar, Visualizar e Remover um curso.
    - Atributos de um curso são:
        - Título (obrigatório)
        - Descrição
        - CRUD de Alunos

### 2. Criar um gerenciamento onde seja possível Criar, Listar, Editar, Visualizar e Remover um aluno.

    - Atributos de um aluno são:
        - Nome (obrigatório)
        - E-mail (obrigatório)
        - Sexo
        - Data de nascimento (obrigatório)

### 3. CRUD de Matrículas: Criar um gerenciamento onde seja possível Criar, Listar, Editar, Visualizar e
Remover uma matrícula.

    - Instruções
    - Deve ser utilizado o Composer para gerenciar as dependências da aplicação.
    - Enviar a estrutura do banco ou instruções que permita a criação do mesmo.

### 4. Criar um README com orientações para instalação e utilização dos serviços.

### 5. Extras

    - Cobrir pelo menos 3 recursos de seu código com testes unitários.
    - Utilizar melhores práticas da Orientação a Objetos.
    - As tabelas do banco de dados criadas através de migrations.

### 6. Observações

    - Se não for possível terminar todas as funcionalidades, não tem problema.
    - Não precisa ser complexo, com várias lib’s e etc. Utilize apenas o necessário para ter um código limpo, de qualidade e de fácil evolução.
    - Para um código de qualidade, você pode e deve fazer o que achar necessário para isso, mesmo que não esteja listado aqui.


### 7. Instalação do projeto

Execute o seguinte comando no terminal em uma pasta de sua preferência:

`git clone git@github.com:marcuscarvalho6/matriculas.git`

Prossiga para a pasta da aplicação

`cd matriculas`

Faça a instalação das dependências através do composer:

`composer install`

Faça uma cópia do seu arquivo .env:

`cp .env.example .env`

Abra seu arquivo de enviroment com seu editor de preferência, ou simplesmente execute no terminal:

Utilizando o Vim:

`vi .env`

Utilizando o Nano:

`nano .env`

Configure suas variáveis de ambiente para seu banco de dados:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pluri
DB_USERNAME=root
DB_PASSWORD=
```

Gere uma nova chave para APP_KEY:

`php artisan key:generate`

Dê as permissões necessárias para permitir a escrita nas seguintes pastas:

`storage` e `bootstrap`

Exemplo:

`chmod -R 775 storage`

`chmod -R 775 bootstrap`

Após a criação do banco de dados que será utilizado na aplicação se setá-lo no .env como descrito acima, execute o seguinte comando para a criação das tabelas através das migrations:

`php artisan migrate`

Para popular o banco de dados foram criadas factories específicas para Students e Courses que podem ser executadas através do comando:

`php artisan db:seed`

Para executar o projeto, utilize o Valet ou simplesmente execute:

`php artisan serve`

# Documentação da API

## Alunos

#### Listagem de Alunos

`GET http://127.0.0.1:8000/students`

Parâmetros aceitos:

```
orderBy (String): name, -name, email, -email, date_of_birth, -date_of_birth, id, -id
```

```
search (String)
```

```
page (Integer)
```

Exemplo, para listar estudantes ordenados decrescentemente por ID:

`GET http://127.0.0.1:8000/students?orderBy=-id`



Permite que um usuário seja buscado através do nome ou email.
Exemplo de busca:

`GET http://127.0.0.1:8000/students?search=Maria`

Exemplo de retorno:

```
{
    "current_page": 1,
    "data": [
        {
            "id": 243,
            "name": "Christian Alonso Mendes",
            "email": "medina.alonso@rocha.net",
            "date_of_birth": "2007-09-24",
            "gender": "F",
            "created_at": "2020-03-04T00:00:23.000000Z",
            "updated_at": "2020-03-04T00:00:23.000000Z"
        }
    ],
    "first_page_url": "http://127.0.0.1:8000/api/students?page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http://127.0.0.1:8000/api/students?page=1",
    "next_page_url": null,
    "path": "http://127.0.0.1:8000/api/students",
    "per_page": 20,
    "prev_page_url": null,
    "to": 1,
    "total": 1
}
```

#### Cadastro de Alunos

Permite efetuar o cadastro de um novo Aluno. Para isso, os seguintes campos devem ser informados:

`POST http://127.0.0.1:8000/students`

Parâmetros da requisição (form data):

```
'name' => 'required',
'email' => 'required|email|unique:students,email',
'date_of_birth' => 'required|date_format:d/m/Y',
'gender' => 'required|in:M,F'
```

#### Update de Aluno

Permite fazer alteraçãos nos dados de um Aluno especifico.

`PUT|PATCH http://127.0.0.1:8000/students/{id}`

Parâmetros da requisição (form data):

```
'name' => 'required',
'email' => 'required|email|unique:students,email',
'date_of_birth' => 'required|date_format:d/m/Y',
'gender' => 'required|in:M,F'
```

#### Exibir detalhes de um Aluno

Exibe detalhes do cadastro de um aluno específico.

`GET http://127.0.0.1:8000/students/1`

Exemplo de retorno da requisição:

```
{
    "id": 1,
    "name": "Dr. Adriana Catarina Cervantes",
    "email": "ana.teles@gmail.com",
    "date_of_birth": "1996-11-01",
    "gender": "M",
    "created_at": "2020-03-04T00:00:23.000000Z",
    "updated_at": "2020-03-04T00:00:23.000000Z"
}
```

#### Excluir Aluno

Permite excluir um Aluno específico.

`DELETE http://127.0.0.1:8000/students/1`


## Cursos

#### Listagem de Cursos

`GET http://127.0.0.1:8000/courses`

Parâmetros aceitos:

```
orderBy (String): title, -title
```

```
search (String)
```

```
page (Integer)
```

Exemplo, para listar cursos ordenados decrescentemente por título:

`GET http://127.0.0.1:8000/courses?orderBy=-title`

Permite que um curso seja buscado através do título ou descrição.
Exemplo de busca:

`GET http://127.0.0.1:8000/courses?search=Gas+Plant`

Exemplo de retorno:

```
{
    "current_page": 1,
    "data": [
        {
            "id": 1,
            "title": "Gas Plant Operator",
            "description": "Voluptas ea iste sunt sit. Id vitae debitis illum aut. Architecto voluptatem et aperiam.",
            "created_at": "2020-03-04T00:00:23.000000Z",
            "updated_at": "2020-03-04T00:00:23.000000Z"
        }
    ],
    "first_page_url": "http://127.0.0.1:8000/api/courses?page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http://127.0.0.1:8000/api/courses?page=1",
    "next_page_url": null,
    "path": "http://127.0.0.1:8000/api/courses",
    "per_page": 20,
    "prev_page_url": null,
    "to": 1,
    "total": 1
}
```

#### Cadastro de Curso

Permite efetuar o cadastro de um novo Curso. Para isso, os seguintes campos devem ser informados:

`POST http://127.0.0.1:8000/courses`

Parâmetros da requisição (form data):

```
'title' => 'required|unique:courses,title',
'description' => 'required'
```

#### Update de Curso

Permite fazer alteraçãos nos dados de um Curso especifico.

`PUT|PATCH http://127.0.0.1:8000/courses/{id}`

Parâmetros da requisição (form data):

```
'title' => 'required|unique:courses,title',
'description' => 'required'
```

#### Exibir detalhes de um Curso

Exibe detalhes do cadastro de um curso específico.

`GET http://127.0.0.1:8000/courses/1`

Exemplo de retorno da requisição:

```
{
    "id": 1,
    "title": "Gas Plant Operator",
    "description": "Voluptas ea iste sunt sit. Id vitae debitis illum aut. Architecto voluptatem et aperiam.",
    "created_at": "2020-03-04T00:00:23.000000Z",
    "updated_at": "2020-03-04T00:00:23.000000Z"
}
```

#### Excluir Curso

Permite excluir um Curso específico.

`DELETE http://127.0.0.1:8000/courses/1`


## Matrícula

#### Listagem de Matriculas

`GET http://127.0.0.1:8000/studentRegistrations`

Parâmetros aceitos:

```
orderBy (String): title, -title, name, -name, email, -email, age, -age, id, -id
```

```
search (String)
```

```
page (Integer)
```

Exemplo, para listar matriculas ordenados decrescentemente por id:

`GET http://127.0.0.1:8000/studentRegistrations?orderBy=-id`

Permite que uma matrícula seja buscado através do nome ou email do aluno.
Exemplo de busca:

`GET http://127.0.0.1:8000/studentRegistrations?search=Adriana`

Exemplo de retorno:

```
{
    "current_page": 1,
    "data": [
        {
            "id": 1,
            "name": "Dr. Adriana Catarina Cervantes",
            "email": "ana.teles@gmail.com",
            "date_of_birth": "1996-11-01",
            "gender": "M",
            "title": "Communications Teacher",
            "description": "Est quia pariatur enim eum. Harum et quis quia. Eos doloremque incidunt expedita quae est labore magni. Odit voluptate pariatur dolor quod.",
            "created_at": "2020-03-04T02:52:48.000000Z",
            "updated_at": "2020-03-04T02:52:48.000000Z"
        },
        {
            "id": 3,
            "name": "Dr. Adriana Catarina Cervantes",
            "email": "ana.teles@gmail.com",
            "date_of_birth": "1996-11-01",
            "gender": "M",
            "title": "HR Specialist",
            "description": "Tempora maiores voluptatem molestias quaerat enim. Ipsa aliquid impedit fugit sunt minima occaecati. Quia molestiae aut et assumenda repellendus sed corporis. Delectus aut harum ipsam.",
            "created_at": "2020-03-04T05:17:42.000000Z",
            "updated_at": "2020-03-04T05:17:42.000000Z"
        }
    ],
    "first_page_url": "http://127.0.0.1:8000/api/studentRegistrations?page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http://127.0.0.1:8000/api/studentRegistrations?page=1",
    "next_page_url": null,
    "path": "http://127.0.0.1:8000/api/studentRegistrations",
    "per_page": 20,
    "prev_page_url": null,
    "to": 2,
    "total": 2
}
```

#### Cadastro de Matrícula

Permite efetuar o cadastro de uma matrícula de um aluno em um Curso. Para isso, os seguintes campos devem ser informados:

`POST http://127.0.0.1:8000/studentRegistrations`

Parâmetros da requisição (form data):

```
'student_id' => 'required|exists:students,id',
'course_id' => 'required|exists:courses,id'
```

#### Update de uma Matrícula

Permite fazer alteraçãos nos dados de uma Matrícula de um aluno em um Curso especifico.

`PUT|PATCH http://127.0.0.1:8000/studentRegistrations/{id}`

Parâmetros da requisição (form data):

```
'student_id' => 'required|exists:students,id',
'course_id' => 'required|exists:courses,id'
```

#### Exibir detalhes de uma Matrícula

Exibe detalhes do cadastro de um curso específico.

`GET http://127.0.0.1:8000/studentRegistrations/1`

Exemplo de retorno da requisição:

```
{
    "id": 1,
    "name": "Dr. Adriana Catarina Cervantes",
    "email": "ana.teles@gmail.com",
    "date_of_birth": "1996-11-01",
    "gender": "M",
    "title": "Communications Teacher",
    "description": "Est quia pariatur enim eum. Harum et quis quia. Eos doloremque incidunt expedita quae est labore magni. Odit voluptate pariatur dolor quod.",
    "created_at": "2020-03-04T02:52:48.000000Z",
    "updated_at": "2020-03-04T02:52:48.000000Z"
}
```

#### Excluir uma Matrícula

Permite excluir uma Matrícula específica.

`DELETE http://127.0.0.1:8000/studentRegistrations/1`

## Relatórios

Permite exibir um relatório que atende o seguinte requisito:

Uma requisição que informe o total de alunos por faixa etária separados por curso e sexo.

    - Menor que 15 anos
    - Entre 15 e 18 anos
    - Entre 19 e 24 anos
    - Entre 25 e 30 anos
    - Maior que 30 anos


URL:

`GET http://127.0.0.1:8000/api/studentRegistrations/statistics`


Exemplo de retorno:

```
[
    {
        "student_id": 8,
        "course_id": 1,
        "course": "Gas Plant Operator",
        "total_male": "0",
        "total_female": "1",
        "age_below_15": "0",
        "age_15_18": "0",
        "age_19_24": "0",
        "age_25_30": "0",
        "age_above_30": "1",
        "students": [
            {
                "id": 1,
                "name": "Dr. Adriana Catarina Cervantes",
                "email": "ana.teles@gmail.com",
                "date_of_birth": "1996-11-01",
                "gender": "M",
                "created_at": "2020-03-04T00:00:23.000000Z",
                "updated_at": "2020-03-04T00:00:23.000000Z",
                "pivot": {
                    "student_id": 8,
                    "course_id": 1
                }
            },
            {
                "id": 2,
                "name": "Sérgio Fernando Pacheco Sobrinho",
                "email": "ziraldo10@franco.com",
                "date_of_birth": "1983-06-04",
                "gender": "M",
                "created_at": "2020-03-04T00:00:23.000000Z",
                "updated_at": "2020-03-04T00:00:23.000000Z",
                "pivot": {
                    "student_id": 8,
                    "course_id": 2
                }
            }
        ]
    },
    {
        "student_id": 7,
        "course_id": 2,
        "course": "Director Of Social Media Marketing",
        "total_male": "1",
        "total_female": "0",
        "age_below_15": "0",
        "age_15_18": "0",
        "age_19_24": "0",
        "age_25_30": "1",
        "age_above_30": "0",
        "students": [
            {
                "id": 2,
                "name": "Sérgio Fernando Pacheco Sobrinho",
                "email": "ziraldo10@franco.com",
                "date_of_birth": "1983-06-04",
                "gender": "M",
                "created_at": "2020-03-04T00:00:23.000000Z",
                "updated_at": "2020-03-04T00:00:23.000000Z",
                "pivot": {
                    "student_id": 7,
                    "course_id": 2
                }
            },
            {
                "id": 5,
                "name": "Dr. Valéria Micaela da Cruz Jr.",
                "email": "vurias@gmail.com",
                "date_of_birth": "1985-09-30",
                "gender": "M",
                "created_at": "2020-03-04T00:00:23.000000Z",
                "updated_at": "2020-03-04T00:00:23.000000Z",
                "pivot": {
                    "student_id": 7,
                    "course_id": 5
                }
            }
        ]
    },
    {
        "student_id": 8,
        "course_id": 2,
        "course": "Director Of Social Media Marketing",
        "total_male": "0",
        "total_female": "1",
        "age_below_15": "0",
        "age_15_18": "0",
        "age_19_24": "0",
        "age_25_30": "0",
        "age_above_30": "1",
        "students": [
            {
                "id": 1,
                "name": "Dr. Adriana Catarina Cervantes",
                "email": "ana.teles@gmail.com",
                "date_of_birth": "1996-11-01",
                "gender": "M",
                "created_at": "2020-03-04T00:00:23.000000Z",
                "updated_at": "2020-03-04T00:00:23.000000Z",
                "pivot": {
                    "student_id": 8,
                    "course_id": 1
                }
            },
            {
                "id": 2,
                "name": "Sérgio Fernando Pacheco Sobrinho",
                "email": "ziraldo10@franco.com",
                "date_of_birth": "1983-06-04",
                "gender": "M",
                "created_at": "2020-03-04T00:00:23.000000Z",
                "updated_at": "2020-03-04T00:00:23.000000Z",
                "pivot": {
                    "student_id": 8,
                    "course_id": 2
                }
            }
        ]
    },
    {
        "student_id": 1,
        "course_id": 3,
        "course": "Communications Teacher",
        "total_male": "2",
        "total_female": "0",
        "age_below_15": "0",
        "age_15_18": "0",
        "age_19_24": "1",
        "age_25_30": "0",
        "age_above_30": "1",
        "students": [
            {
                "id": 3,
                "name": "Dr. Sebastião Pedro Ramires Sobrinho",
                "email": "josefina21@matias.biz",
                "date_of_birth": "1999-01-12",
                "gender": "M",
                "created_at": "2020-03-04T00:00:23.000000Z",
                "updated_at": "2020-03-04T00:00:23.000000Z",
                "pivot": {
                    "student_id": 1,
                    "course_id": 3
                }
            },
            {
                "id": 5,
                "name": "Dr. Valéria Micaela da Cruz Jr.",
                "email": "vurias@gmail.com",
                "date_of_birth": "1985-09-30",
                "gender": "M",
                "created_at": "2020-03-04T00:00:23.000000Z",
                "updated_at": "2020-03-04T00:00:23.000000Z",
                "pivot": {
                    "student_id": 1,
                    "course_id": 5
                }
            }
        ]
    },
    {
        "student_id": 18,
        "course_id": 3,
        "course": "Communications Teacher",
        "total_male": "0",
        "total_female": "2",
        "age_below_15": "0",
        "age_15_18": "1",
        "age_19_24": "0",
        "age_25_30": "0",
        "age_above_30": "1",
        "students": [
            {
                "id": 3,
                "name": "Dr. Sebastião Pedro Ramires Sobrinho",
                "email": "josefina21@matias.biz",
                "date_of_birth": "1999-01-12",
                "gender": "M",
                "created_at": "2020-03-04T00:00:23.000000Z",
                "updated_at": "2020-03-04T00:00:23.000000Z",
                "pivot": {
                    "student_id": 18,
                    "course_id": 3
                }
            }
        ]
    },
    {
        "student_id": 22,
        "course_id": 4,
        "course": "City Planning Aide",
        "total_male": "0",
        "total_female": "1",
        "age_below_15": "0",
        "age_15_18": "1",
        "age_19_24": "0",
        "age_25_30": "0",
        "age_above_30": "0",
        "students": [
            {
                "id": 3,
                "name": "Dr. Sebastião Pedro Ramires Sobrinho",
                "email": "josefina21@matias.biz",
                "date_of_birth": "1999-01-12",
                "gender": "M",
                "created_at": "2020-03-04T00:00:23.000000Z",
                "updated_at": "2020-03-04T00:00:23.000000Z",
                "pivot": {
                    "student_id": 22,
                    "course_id": 3
                }
            },
            {
                "id": 4,
                "name": "João Colaço Vale Sobrinho",
                "email": "faro.ziraldo@carmona.net",
                "date_of_birth": "1987-05-18",
                "gender": "M",
                "created_at": "2020-03-04T00:00:23.000000Z",
                "updated_at": "2020-03-04T00:00:23.000000Z",
                "pivot": {
                    "student_id": 22,
                    "course_id": 4
                }
            }
        ]
    },
    {
        "student_id": 1,
        "course_id": 5,
        "course": "HR Specialist",
        "total_male": "5",
        "total_female": "0",
        "age_below_15": "0",
        "age_15_18": "0",
        "age_19_24": "2",
        "age_25_30": "1",
        "age_above_30": "2",
        "students": [
            {
                "id": 3,
                "name": "Dr. Sebastião Pedro Ramires Sobrinho",
                "email": "josefina21@matias.biz",
                "date_of_birth": "1999-01-12",
                "gender": "M",
                "created_at": "2020-03-04T00:00:23.000000Z",
                "updated_at": "2020-03-04T00:00:23.000000Z",
                "pivot": {
                    "student_id": 1,
                    "course_id": 3
                }
            },
            {
                "id": 5,
                "name": "Dr. Valéria Micaela da Cruz Jr.",
                "email": "vurias@gmail.com",
                "date_of_birth": "1985-09-30",
                "gender": "M",
                "created_at": "2020-03-04T00:00:23.000000Z",
                "updated_at": "2020-03-04T00:00:23.000000Z",
                "pivot": {
                    "student_id": 1,
                    "course_id": 5
                }
            }
        ]
    },
    {
        "student_id": 16,
        "course_id": 5,
        "course": "HR Specialist",
        "total_male": "0",
        "total_female": "1",
        "age_below_15": "1",
        "age_15_18": "0",
        "age_19_24": "0",
        "age_25_30": "0",
        "age_above_30": "0",
        "students": [
            {
                "id": 5,
                "name": "Dr. Valéria Micaela da Cruz Jr.",
                "email": "vurias@gmail.com",
                "date_of_birth": "1985-09-30",
                "gender": "M",
                "created_at": "2020-03-04T00:00:23.000000Z",
                "updated_at": "2020-03-04T00:00:23.000000Z",
                "pivot": {
                    "student_id": 16,
                    "course_id": 5
                }
            },
            {
                "id": 6,
                "name": "Sra. Rafaela Torres Jr.",
                "email": "rsepulveda@mendonca.com",
                "date_of_birth": "2000-04-21",
                "gender": "M",
                "created_at": "2020-03-04T00:00:23.000000Z",
                "updated_at": "2020-03-04T00:00:23.000000Z",
                "pivot": {
                    "student_id": 16,
                    "course_id": 6
                }
            },
            {
                "id": 10,
                "name": "Srta. Sofia Teles Garcia Jr.",
                "email": "aranda.emilia@gmail.com",
                "date_of_birth": "1996-11-12",
                "gender": "M",
                "created_at": "2020-03-04T00:00:23.000000Z",
                "updated_at": "2020-03-04T00:00:23.000000Z",
                "pivot": {
                    "student_id": 16,
                    "course_id": 10
                }
            }
        ]
    },
    {
        "student_id": 11,
        "course_id": 6,
        "course": "Director Religious Activities",
        "total_male": "0",
        "total_female": "3",
        "age_below_15": "1",
        "age_15_18": "0",
        "age_19_24": "0",
        "age_25_30": "1",
        "age_above_30": "1",
        "students": [
            {
                "id": 6,
                "name": "Sra. Rafaela Torres Jr.",
                "email": "rsepulveda@mendonca.com",
                "date_of_birth": "2000-04-21",
                "gender": "M",
                "created_at": "2020-03-04T00:00:23.000000Z",
                "updated_at": "2020-03-04T00:00:23.000000Z",
                "pivot": {
                    "student_id": 11,
                    "course_id": 6
                }
            }
        ]
    },
    {
        "student_id": 16,
        "course_id": 10,
        "course": "Woodworking Machine Setter",
        "total_male": "0",
        "total_female": "1",
        "age_below_15": "1",
        "age_15_18": "0",
        "age_19_24": "0",
        "age_25_30": "0",
        "age_above_30": "0",
        "students": [
            {
                "id": 5,
                "name": "Dr. Valéria Micaela da Cruz Jr.",
                "email": "vurias@gmail.com",
                "date_of_birth": "1985-09-30",
                "gender": "M",
                "created_at": "2020-03-04T00:00:23.000000Z",
                "updated_at": "2020-03-04T00:00:23.000000Z",
                "pivot": {
                    "student_id": 16,
                    "course_id": 5
                }
            },
            {
                "id": 6,
                "name": "Sra. Rafaela Torres Jr.",
                "email": "rsepulveda@mendonca.com",
                "date_of_birth": "2000-04-21",
                "gender": "M",
                "created_at": "2020-03-04T00:00:23.000000Z",
                "updated_at": "2020-03-04T00:00:23.000000Z",
                "pivot": {
                    "student_id": 16,
                    "course_id": 6
                }
            },
            {
                "id": 10,
                "name": "Srta. Sofia Teles Garcia Jr.",
                "email": "aranda.emilia@gmail.com",
                "date_of_birth": "1996-11-12",
                "gender": "M",
                "created_at": "2020-03-04T00:00:23.000000Z",
                "updated_at": "2020-03-04T00:00:23.000000Z",
                "pivot": {
                    "student_id": 16,
                    "course_id": 10
                }
            }
        ]
    }
]
```