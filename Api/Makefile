.PHONY: run install freeze migrate

run:
	python manage.py runserver

install:
	pip install -r requirements.txt

freeze:
	pip freeze > requirements.txt

migrate:
	python manage.py migrate

schema:
	python manage.py graphql_schema --out=../schema.json

