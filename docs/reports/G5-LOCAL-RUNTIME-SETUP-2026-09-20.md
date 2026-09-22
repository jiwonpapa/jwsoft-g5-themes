# G5 로컬 검증 환경 구축 보고서

- 구축일: 2026-09-20
- 상태: 실행 중·기본 화면 검증 완료
- 범위: 개발 기준 G5 설치와 Mac mini ↔ Ubuntu 사설 TLS 연결
- 테마 구현: 미착수

## 결과

사무실 Ubuntu에 기존 서비스와 분리된 G5 검증 환경을 구축했습니다. Mac mini에서 `https://g5themes.test`로 접속하며 mkcert 사설 CA 검증이 통과합니다.

| 항목 | 확정값 |
| --- | --- |
| 개발 도메인 | `g5themes.test` |
| Ubuntu | `localubuntu`, `192.168.0.127` |
| G5 | 5.6.391, commit `148d748c2d3fe60a536966164d1d7dbbe6f9c477` |
| G5 공식 archive SHA-256 | `318a9346c113e0be92a51ec7bdcb4d3b81566e75f5d5dd42e14db74a2e27b111` |
| PHP | 8.3.33 FPM |
| MySQL | 8.4.11 |
| 내부 웹 포트 | `127.0.0.1:18085` |
| 공개 개발 포트 | Ubuntu 호스트 Nginx의 80·443 |
| DB 노출 | Compose 내부 네트워크만 사용 |
| 영카트 | 설치하지 않음 |

PHP에는 `curl`, `exif`, `fileinfo`, `gd`, `intl`, `mbstring`, `mysqli`, `openssl`, `zip`, OPcache를 포함했습니다. MySQL에는 G5 커뮤니티 설치 기준 37개 테이블이 있고 `g5_shop_` 테이블은 없습니다.

## 연결 구조

```text
Mac mini /etc/hosts
  g5themes.test -> 192.168.0.127
    -> Ubuntu host Nginx :443 (mkcert TLS)
      -> 127.0.0.1:18085
        -> Compose Nginx :8080
          -> PHP 8.3 FPM
          -> MySQL 8.4 internal network
```

기존 Ubuntu Nginx는 새 `50-g5themes.test.conf`만 추가했습니다. 기존 PHP 8.4·8.5와 기존 MariaDB 컨테이너, 기존 3306·3307·3308 포트는 변경하지 않았습니다. 새 MySQL은 호스트 포트를 발행하지 않습니다.

## 파일 위치

| 목적 | 위치 |
| --- | --- |
| 저장소 정의 | `harness/runtime/g5themes-test/` |
| Ubuntu 실행본 | `/home/neojins/services/g5themes-test/` |
| Ubuntu 가상 호스트 | `/etc/nginx/conf.d/50-g5themes.test.conf` |
| Ubuntu 인증서 | `/etc/nginx/tls/g5themes.test.pem` |
| Mac 인증서 원본 | `~/Library/Application Support/JWSoft/g5themes-test/` |
| DB 비밀값 | Ubuntu 실행본의 `.env`, 권한 `0600` |
| G5 관리자 비밀값 | Ubuntu 실행본의 `.admin.env`, 권한 `0600` |

인증서는 `g5themes.test`, `localhost`, `127.0.0.1`, `::1`, `192.168.0.127`을 포함하며 만료일은 2028-12-20입니다. 비밀번호와 개인키는 저장소에 포함하지 않습니다.

## 검증 결과

- HTTP 접속은 HTTPS로 301 이동합니다.
- macOS curl의 TLS 검증 결과는 `0`, 최종 응답은 200입니다.
- PC 홈, 모바일 홈, 로그인, 자유게시판이 실제 브라우저에서 열립니다.
- G5가 만든 내부 링크는 `https://g5themes.test` 기준이며 내부 포트가 노출되지 않습니다.
- 기본 outlogin의 20자 제한에 맞춰 개발 관리자 비밀번호를 20자로 재발급하고 메인 화면 로그인을 확인했습니다.
- PHP-FPM과 MySQL healthcheck가 정상입니다.
- `data/dbconfig.php`는 권한 `0600`이며 `/data/*.php` 직접 요청은 403으로 차단됩니다.
- 웹·PHP 로그에서 fatal, error, critical, emergency 항목이 발견되지 않았습니다.
- 임시 검증 포트 18443은 제거했으며 새 DB 호스트 포트는 없습니다.

## 2026-09-21 JW-Business 개발본 적용

- 로컬 build payload 388개를 `/home/neojins/services/g5themes-test/site/theme/jw_business`에 동기화했습니다.
- G5 설정의 활성 테마를 `basic`에서 `jw_business`로 변경했습니다.
- PC 메인과 CSS·JavaScript가 200으로 응답하고 Edge에서 새 헤더·메인 7개 섹션·푸터가 렌더링되는 것을 확인했습니다.
- `.admin.env`의 현재 계정으로 로그인 요청 302와 `/adm/` 200, 환경설정·회원관리·게시판관리 노출을 확인했습니다. 비밀번호는 문서에 기록하지 않습니다.
- 이번 확인은 작업 중 개발본의 단일 적용 smoke입니다. 판매 ZIP 설치·업데이트·원복 및 전체 기능 시험이 아닙니다.

## 운영 경계

이 환경은 테마 개발·설치 시험용입니다. G5 코어를 상품에 포함하거나 수정하는 근거가 아닙니다. 테마 상품은 공식 `theme/basic`을 테마명 폴더로 복제한 뒤 코어 수정 없이 개발하고, 판매 ZIP에는 빌드 도구·DB·인증서·비밀번호를 넣지 않습니다.

현재 통과한 것은 기준 G5의 수동 smoke입니다. 3단계 하네스 완료에는 fixture 초기화, 테마 ZIP 설치·업데이트·원복, 반복 가능한 browser scenario와 시각 기준본이 더 필요합니다.
