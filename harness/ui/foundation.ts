import { root, themeRoot } from './catalog';
const commands = [
  ['bun','run','contracts:check'], ['bun','run','contracts:test'], ['bun','run','tokens:test'], ['bun','run','tooling:test'],
  ['bun','run','third-party:check'], ['bun','run','harness:test'], ['bun','run','harness:typecheck'], ['bun','run','stack:check'],
  ...['structure:check','tokens:check','typecheck','build','test','check:build'].map(name => ['bun','run','--cwd',themeRoot,name]),
];
for (const args of commands) {
  const child = Bun.spawn(args,{cwd:root,stdout:'inherit',stderr:'inherit'});
  if (await child.exited) process.exit(1);
}
console.log('Foundation passed. Product quality and browser verdict remain separate gates.');
