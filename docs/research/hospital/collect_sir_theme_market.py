#!/usr/bin/env python3
"""Collect the public SIR theme-category listing into a reviewable CSV snapshot.

The SIR item id is also its registration Unix timestamp. A known item
(1587282183) resolves to its displayed registration date, 2020-04-19.
Sales are cumulative observations shown by SIR, not period sales.
"""

from __future__ import annotations

import csv
import datetime as dt
import html
import re
import statistics
from concurrent.futures import ThreadPoolExecutor
from pathlib import Path
from urllib.request import Request, urlopen


PAGES = range(1, 27)
BASE_URL = "https://sir.kr/contents-mall/search"
SNAPSHOT_DATE = dt.date(2026, 9, 20)
OUTPUT_DIR = Path(__file__).resolve().parent


def clean(value: str) -> str:
    return re.sub(r"\s+", " ", html.unescape(re.sub(r"<[^>]+>", "", value))).strip()


def fetch_page(page: int) -> list[dict[str, object]]:
    url = f"{BASE_URL}?qcaid=10&qsort=od_newest&qorder=desc&page={page}"
    request = Request(url, headers={"User-Agent": "Mozilla/5.0"})
    source = urlopen(request, timeout=20).read().decode("utf-8", "replace")
    parts = re.split(
        r'<a href="https://sir\.kr/contents-mall/items/(\d+)" class="group h-full">',
        source,
    )
    rows: list[dict[str, object]] = []
    for index in range(1, len(parts), 2):
        item_id = parts[index]
        block = parts[index + 1].split("</a>", 1)[0]
        title_match = re.search(r"<h3[^>]*>(.*?)</h3>", block, re.S)
        category_matches = re.findall(
            r'<span class="text-xs text-gray-500 dark:text-gray-400 truncate">(.*?)</span>',
            block,
            re.S,
        )
        price_match = re.search(
            r'<span class="text-base sm:text-xl font-bold[^>]*>([\d,]+)원</span>',
            block,
        )
        sales_match = re.search(
            r'<span class="text-xs text-gray-500 dark:text-gray-400">판매(\d+)</span>',
            block,
        )
        if not (title_match and price_match and sales_match):
            continue

        registered_at = dt.datetime.fromtimestamp(
            int(item_id), dt.timezone(dt.timedelta(hours=9))
        ).date()
        rows.append(
            {
                "item_id": item_id,
                "registered_at": registered_at.isoformat(),
                "title": clean(title_match.group(1)),
                "display_category": clean(category_matches[0]) if category_matches else "",
                "price_krw": int(price_match.group(1).replace(",", "")),
                "cumulative_sales": int(sales_match.group(1)),
                "source_url": f"https://sir.kr/contents-mall/items/{item_id}",
                "listing_url": url,
                "observed_at": SNAPSHOT_DATE.isoformat(),
            }
        )
    return rows


def summarize(label: str, rows: list[dict[str, object]]) -> dict[str, object]:
    prices = [int(row["price_krw"]) for row in rows]
    sales = [int(row["cumulative_sales"]) for row in rows]
    return {
        "cohort": label,
        "items": len(rows),
        "median_price_krw": int(statistics.median(prices)) if prices else "",
        "zero_sales_items": sum(value == 0 for value in sales),
        "zero_sales_pct": round(100 * sum(value == 0 for value in sales) / len(rows), 1)
        if rows
        else "",
        "median_cumulative_sales": statistics.median(sales) if sales else "",
        "total_cumulative_sales": sum(sales),
        "note": "Cumulative sales are not sales velocity.",
    }


def main() -> None:
    with ThreadPoolExecutor(max_workers=6) as executor:
        rows = [row for page_rows in executor.map(fetch_page, PAGES) for row in page_rows]
    rows = list({str(row["item_id"]): row for row in rows}.values())
    rows.sort(key=lambda row: int(row["item_id"]), reverse=True)

    raw_path = OUTPUT_DIR / "sir-theme-market-snapshot-2026-09-20.csv"
    with raw_path.open("w", newline="", encoding="utf-8") as file:
        writer = csv.DictWriter(file, fieldnames=list(rows[0]))
        writer.writeheader()
        writer.writerows(rows)

    cohorts: list[dict[str, object]] = []
    for year in range(2017, 2027):
        cohorts.append(
            summarize(
                str(year),
                [row for row in rows if str(row["registered_at"]).startswith(str(year))],
            )
        )
    for days in (30, 60, 90, 180, 365):
        cohorts.append(
            summarize(
                f"last_{days}_days",
                [
                    row
                    for row in rows
                    if (
                        SNAPSHOT_DATE
                        - dt.date.fromisoformat(str(row["registered_at"]))
                    ).days
                    <= days
                ],
            )
        )

    summary_path = OUTPUT_DIR / "sir-theme-market-cohorts-2026-09-20.csv"
    with summary_path.open("w", newline="", encoding="utf-8") as file:
        writer = csv.DictWriter(file, fieldnames=list(cohorts[0]))
        writer.writeheader()
        writer.writerows(cohorts)

    print(f"wrote {len(rows)} items to {raw_path}")
    print(f"wrote {len(cohorts)} cohorts to {summary_path}")


if __name__ == "__main__":
    main()
