# `g5themes.test` Ubuntu 검증 환경

이 환경은 기존 Ubuntu Nginx·PHP·DB를 바꾸지 않고 G5 테마 검증용 PHP 8.3과 MySQL 8.4를 격리합니다.

현재 기준은 G5 5.6.391, PHP 8.3.33, MySQL 8.4.11입니다. 이 디렉터리는 재현 가능한 인프라 정의만 추적하며 G5 원본·DB·인증서·비밀번호는 추적하지 않습니다.

## 경로와 포트

- 서버 작업 경로: `/home/neojins/services/g5themes-test`
- G5 원본: `site/`
- 내부 HTTP: `127.0.0.1:18085`
- 최종 주소: `https://g5themes.test`
- DB: Compose 내부 네트워크에만 노출
- TLS 종료: Ubuntu 호스트 Nginx

`.env`, 관리자 비밀번호, `site/data`, TLS 개인키는 Git에 넣지 않습니다.

처음 준비할 때 `.env.example`을 `.env`로 복사하고 두 비밀번호 항목을 임의의 긴 값으로 바꿉니다. 공식 G5 원본은 [`../../upstream/gnuboard5.lock.json`](../../upstream/gnuboard5.lock.json)의 tag·commit·SHA-256과 일치하는 archive만 사용합니다.

## 운영 명령

```bash
docker compose up -d --build
docker compose ps
docker compose exec php php -v
docker compose exec db mysql -uroot -p -e 'SELECT VERSION();'
```

관리자 계정은 서버의 `.admin.env`, DB 계정은 `.env`에만 저장하며 두 파일은 권한 `0600`과 Git 제외 상태를 유지합니다.

G5 5.6.391 기본 outlogin 스킨의 비밀번호 입력은 `maxlength=20`입니다. 개발 관리자 비밀번호도 20자 이하로 생성해야 메인 화면과 관리자 전용 로그인 화면에서 동일하게 동작합니다.

호스트 Nginx 활성화는 서버에서 다음 파일만 root 권한으로 설치합니다.

```bash
sudo ./activate-host-nginx.sh
```

Mac mini에서는 저장소 루트에서 내부 도메인을 한 번 등록합니다.

```bash
sudo harness/runtime/g5themes-test/activate-mac-host.sh
```

기존 `/etc/nginx/conf.d` 파일과 기존 컨테이너는 수정하지 않습니다.

상세 구축·검증 기록: [`docs/reports/G5-LOCAL-RUNTIME-SETUP-2026-09-20.md`](../../../docs/reports/G5-LOCAL-RUNTIME-SETUP-2026-09-20.md)
