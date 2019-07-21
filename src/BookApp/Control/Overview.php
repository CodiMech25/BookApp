<?php

namespace BookApp\Control;

use BookApp;


class Overview extends BookApp\Runtime\BaseControl
{
    protected $m_books;


    public function __construct(string $controller, string $action) {
        parent::__construct($controller, $action);
        $this->m_books = new BookApp\Model\Books();
    }

    public function actionDefault() {
        $messages = [];

        if (isset($_GET['book-added'])) {
            if ($_GET['book-added'] === '1') {
                $messages[] = [
                    'type' => 'success',
                    'text' => 'Book was successfully added!'
                ];
            } else {
                $messages[] = [
                    'type' => 'failure',
                    'text' => 'Book could not be added!'
                ];
            }
        }

        if (isset($_GET['book-removed'])) {
            if ($_GET['book-removed'] === '1') {
                $messages[] = [
                    'type' => 'success',
                    'text' => 'Book was successfully removed!'
                ];
            } else {
                $messages[] = [
                    'type' => 'failure',
                    'text' => 'Book could not be removed!'
                ];
            }
        }

        $filter_name = null;
        $filter_author = null;
        $filter_year = null;

        if (isset($_POST['filter-books-submit'])) {
            if (!(isset($_POST['name']) && ($filter_name = trim($_POST['name'])) && mb_strlen($filter_name) > 0)) {
                $filter_name = null;
            }

            if (!(isset($_POST['author']) && ($filter_author = trim($_POST['author'])) && mb_strlen($filter_author) > 0)) {
                $filter_author = null;
            }

            if (!(isset($_POST['year']) && ($filter_year = (int)trim($_POST['year'])) && $filter_year > 1000)) {
                $filter_year = null;
            }
        }

        $this->template()->set('filters', [
            'name' => $filter_name,
            'author' => $filter_author,
            'year' => $filter_year
        ]);

        $this->template()->set('messages', $messages);
        $this->template()->set('books', $this->m_books->getAll($filter_name, $filter_author, $filter_year)?: []);
        $this->template()->set('authors', $this->m_books->getAuthors()?: []);
        $this->template()->set('years', $this->m_books->getYears()?: []);
        $this->template()->display();
    }

    public function actionAddBook() {
        $errors = [];

        if (isset($_POST['add-book-submit'])) {
            $name = null;
            $author = null;
            $year = null;
            $isbn = null;

            if (isset($_POST['name']) && ($name = trim($_POST['name'])) && mb_strlen($name) > 0) {
                if (mb_strlen($name) > 128) {
                    $errors[] = 'Name of the book cannot be longer, than 128 characters!';
                }
            } else {
                $errors[] = 'Name of the book must be filled!';
            }

            if (isset($_POST['author']) && ($author = trim($_POST['author'])) && mb_strlen($author) > 0) {
                if (mb_strlen($author) > 64) {
                    $errors[] = 'Name of the author cannot be longer, than 64 characters!';
                }
            } else {
                $errors[] = 'Name of the author must be filled!';
            }

            if (isset($_POST['year']) && ($year = trim($_POST['year'])) && mb_strlen($year) > 0) {
                if (!is_numeric($year) || mb_strlen($year) > 4 && (int)$year < 1000) {
                    $errors[] = 'Given year has an invalid format!';
                }
            } else {
                $errors[] = 'Year must be filled!';
            }

            if (isset($_POST['isbn']) && ($isbn = trim($_POST['isbn']))) {
                if (!preg_match('/^(?:\d[\ |-]?){9}[\d|X]$/i', $isbn) && !preg_match('/^(?:\d[\ |-]?){13}$/i', $isbn)) {
                    $errors[] = 'Given ISBN has an invalid format!';
                }
            }

            if (empty($errors) && $name !== null && $author !== null && $year !== null) {
                if ($this->m_books->add($name, $author, (int)$year, $isbn)) {
                    header('Location: /?book-added=1');
                } else {
                    header('Location: /?book-added=0');
                }
            }

            $this->template()->set('name', $name);
            $this->template()->set('author', $author);
            $this->template()->set('year', $year);
            $this->template()->set('isbn', $isbn);
            $this->template()->set('errors', $errors);
        }

        $this->template()->display();
    }

    public function actionRemoveBook() {
        if (isset($_GET['id']) && (int)$_GET['id'] > 0) {
            $id = (int)$_GET['id'];

            if ($this->m_books->remove($id)) {
                header('Location: /?book-removed=1');
            } else {
                header('Location: /?book-removed=0');
            }
        }
    }
}
