# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Repository Purpose

This is a personal project sandbox (`~/dev/ClaudeCode`) for building small, self-contained web games and tools — each delivered as a single `.html` file (HTML + CSS + JS inline) that can be opened directly in a browser with no build step.

## Conventions

- **One file per project**: each game/tool is a standalone `.html` file at the repo root.
- **No build tooling**: no npm, no bundler, no frameworks. Vanilla HTML/CSS/JS only.
- **Open in browser**: `open <file>.html` to preview locally.

## Git Workflow

After every meaningful change:
1. Commit with a concise, descriptive message.
2. Push to `origin main` (`https://github.com/ptripathi/ClaudeCode.git`).

This keeps GitHub as a running backup and makes it easy to revert to any saved version.
