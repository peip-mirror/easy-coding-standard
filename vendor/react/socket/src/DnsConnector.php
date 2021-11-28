<?php

namespace ECSPrefix20211128\React\Socket;

use ECSPrefix20211128\React\Dns\Resolver\ResolverInterface;
use ECSPrefix20211128\React\Promise;
use ECSPrefix20211128\React\Promise\CancellablePromiseInterface;
final class DnsConnector implements \ECSPrefix20211128\React\Socket\ConnectorInterface
{
    private $connector;
    private $resolver;
    public function __construct(\ECSPrefix20211128\React\Socket\ConnectorInterface $connector, \ECSPrefix20211128\React\Dns\Resolver\ResolverInterface $resolver)
    {
        $this->connector = $connector;
        $this->resolver = $resolver;
    }
    public function connect($uri)
    {
        if (\strpos($uri, '://') === \false) {
            $parts = \parse_url('tcp://' . $uri);
            unset($parts['scheme']);
        } else {
            $parts = \parse_url($uri);
        }
        if (!$parts || !isset($parts['host'])) {
            return \ECSPrefix20211128\React\Promise\reject(new \InvalidArgumentException('Given URI "' . $uri . '" is invalid'));
        }
        $host = \trim($parts['host'], '[]');
        $connector = $this->connector;
        // skip DNS lookup / URI manipulation if this URI already contains an IP
        if (\false !== \filter_var($host, \FILTER_VALIDATE_IP)) {
            return $connector->connect($uri);
        }
        $promise = $this->resolver->resolve($host);
        $resolved = null;
        return new \ECSPrefix20211128\React\Promise\Promise(function ($resolve, $reject) use(&$promise, &$resolved, $uri, $connector, $host, $parts) {
            // resolve/reject with result of DNS lookup
            $promise->then(function ($ip) use(&$promise, &$resolved, $connector, $host, $parts) {
                $resolved = $ip;
                $uri = '';
                // prepend original scheme if known
                if (isset($parts['scheme'])) {
                    $uri .= $parts['scheme'] . '://';
                }
                if (\strpos($ip, ':') !== \false) {
                    // enclose IPv6 addresses in square brackets before appending port
                    $uri .= '[' . $ip . ']';
                } else {
                    $uri .= $ip;
                }
                // append original port if known
                if (isset($parts['port'])) {
                    $uri .= ':' . $parts['port'];
                }
                // append orignal path if known
                if (isset($parts['path'])) {
                    $uri .= $parts['path'];
                }
                // append original query if known
                if (isset($parts['query'])) {
                    $uri .= '?' . $parts['query'];
                }
                // append original hostname as query if resolved via DNS and if
                // destination URI does not contain "hostname" query param already
                $args = array();
                \parse_str(isset($parts['query']) ? $parts['query'] : '', $args);
                if ($host !== $ip && !isset($args['hostname'])) {
                    $uri .= (isset($parts['query']) ? '&' : '?') . 'hostname=' . \rawurlencode($host);
                }
                // append original fragment if known
                if (isset($parts['fragment'])) {
                    $uri .= '#' . $parts['fragment'];
                }
                return $promise = $connector->connect($uri);
            }, function ($e) use($uri, $reject) {
                $reject(new \RuntimeException('Connection to ' . $uri . ' failed during DNS lookup: ' . $e->getMessage(), 0, $e));
            })->then($resolve, $reject);
        }, function ($_, $reject) use(&$promise, &$resolved, $uri) {
            // cancellation should reject connection attempt
            // reject DNS resolution with custom reason, otherwise rely on connection cancellation below
            if ($resolved === null) {
                $reject(new \RuntimeException('Connection to ' . $uri . ' cancelled during DNS lookup'));
            }
            // (try to) cancel pending DNS lookup / connection attempt
            if ($promise instanceof \ECSPrefix20211128\React\Promise\CancellablePromiseInterface) {
                // overwrite callback arguments for PHP7+ only, so they do not show
                // up in the Exception trace and do not cause a possible cyclic reference.
                $_ = $reject = null;
                $promise->cancel();
                $promise = null;
            }
        });
    }
}
