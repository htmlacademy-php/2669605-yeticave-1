up-:
	docker compose -f .docker/docker-compose.yml up -d --build
up:
	docker compose up -d
stop:
	docker compose stop